<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Translate Controller
 *
 * This controller displays the list of language files in the
 * application folders and allows the user to translate
 * 
 */
class Translate extends Admin_Controller
{
    /** @var array The names of the current languages. */
    private $langs;

    //---------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('translate');
        $this->load->helper('languages');
        $this->langs = list_languages();

        Modules::register_asset('/assets/css/Translate.css');
        Modules::register_asset('/assets/js/Translate.js');

    }


    /**
     * Display a list of all core language files, as well as a list of modules
     * the user can choose to edit.
     *
     * @param string $transLang The target language for translation.
     *
     * @return void
     */
    public function index($transLang = '')
    {
        if (empty($transLang)) {
            $config =& get_config();
            $transLang = isset($config['language']) ? $config['language'] : 'english';
        }

        // Selecting a different language?
        if (isset($_POST['select_lang'])) {
            $transLang = $this->input->post('trans_lang') == 'other' ?
                $this->input->post('new_lang') : $this->input->post('trans_lang');
        }

        $data = array('page_title'=>lang('translate_translate'),
         'page_subtitle'=> sprintf(lang('translate_title_index'), ucfirst($transLang)),
         'page_breadcrumb'=>lang('translate_breadcrumb_title'));

        // If the selected language is not in the list of languages, add it.
        if (! in_array($transLang, $this->langs)) {
            $this->langs[] = $transLang;
        }

        // Check whether there are custom modules with lang files.
        $allLangFiles = list_lang_files();
        if (isset($allLangFiles['custom'])) {
            $moduleLangFiles = $allLangFiles['custom'];
            sort($moduleLangFiles);
            $data['modules'] = $moduleLangFiles;
        }

        $coreLangFiles = $allLangFiles['core'];
        sort($coreLangFiles);
        $data['lang_files'] = $coreLangFiles;
        $data['languages'] = $this->langs;
        $data['trans_lang'] = $transLang;

        foreach( $data as $key => $value )
            Template::set($key, $value);
        Template::render();
    }


    //--------------------------------------------------------------------
    // Edit
    //--------------------------------------------------------------------

    /**
     * Display the form which allows the user to translate
     *
    *
     * @param string $transLang The target language for translation.
     * @param string $langFile  The file to translate.
     *
     * @return void
     */
    public function edit($transLang = '', $langFile = '')
    {
        $config =& get_config();
        $origLang = isset($config['language']) ? $config['language'] : 'english';
        $chkd = array();

       $data = array('page_title'=>lang('translate_translate'),
         'page_subtitle'=> sprintf(lang('translate_title_edit'), $langFile, ucfirst($transLang)),
         'page_breadcrumb'=>lang('translate_breadcrumb_title'));

        if ($langFile) {
            $langFile .= '.php';
            // Save the file...
            if (isset($_POST['save'])) {
                // If the file saves successfully, redirect to the index.
                if (save_lang_file($langFile, $transLang, $_POST['lang'])) {
                    Template::set_message(lang('translate_save_success'), 'success');
                    redirect("/translate/index/{$transLang}");
                }

                Template::set_message(lang('translate_save_fail'), 'error');
            }

            // Get the lang file.
            $orig = load_lang_file($langFile, $origLang);
            $new = $transLang ? load_lang_file($langFile, $transLang) : $orig;

            // Translate.
            if (isset($_POST['translate']) && is_array($_POST['checked'])) {
                if (isset($_POST['lang'])) {
                    foreach ($_POST['lang'] as $key => $val) {
                        $new[$key] = $val;
                    }
                }

                if ($transLang) {
                    $this->load->config('langcodes');
                    $codes = $config['translate']['codes']['google'];
                    $transLangCode = isset($codes[$transLang]) ? $codes[$transLang] : '';
                    $origLangCode  = isset($codes[$origLang]) ? $codes[$origLang] : 'en';

                    $errcnt = 0;
                    $cnt = 0;
                    $this->load->library('translate_lib');

                    // Attempt to translate each of the selected values.
                    foreach ($_POST['checked'] as $key) {
                        $new[$key] = '* ' . $new[$key];
                        $val = '';
                        if ($transLangCode) {
                            $val = $this->translate_lib->setLang($origLangCode, $transLangCode)
                                                       ->translate($orig[$key]);
                        }
                        if ($val) {
                            $new[$key] = $val;
                            $cnt++;
                        } else {
                            $errcnt++;
                            $chkd[] = $key;
                        }

                        // Give up if 5 errors occur without any successful attempts,
                        // as this may imply network or other issues.
                        if ($errcnt >= 5 && $cnt == 0) {
                            break;
                        }
                    }

                    if ($errcnt == 0) {
                        Template::set_message(sprintf(lang('translate_success'), $cnt), 'success');
                    } elseif ($cnt > 0) {
                        Template::set_message(sprintf(lang('translate_part_success'), $cnt, $errcnt), 'info');
                    } else {
                        Template::set_message(lang('translate_failed'), 'error');
                    }
                }
            }

            $data['orig'] = $orig;
            $data['new'] = $new;
            $data['lang_file'] = $langFile;
        }

        $data['chkd'] = $chkd;
        $data['orig_lang'] = $origLang;
        $data['trans_lang'] = $transLang;
       
        $data['page_subtitle'] = sprintf(lang('translate_title_edit'), $langFile, ucfirst($transLang));       

        foreach( $data as $key => $value )
            Template::set($key, $value);
        Template::render();
    }


    /**
     * Export a set of files for a language
     *
     * @return void
     */
    public function export()
    {
        if (isset($_POST['export'])) {
            $this->do_export($this->input->post('export_lang'), $this->input->post('include_core'), $this->input->post('include_custom'));
            die();
        }

        Template::set('languages', $this->langs);
        Template::set('toolbar_title', lang('translate_export'));
        Template::render();
    }

    /**
     * Retrieve all files for a language, zip them, and send the zip file to the
     * browser for immediate download
     *
     * @param string $language      The language for which to retrieve the files
     * @param bool $includeCore     Include the core language files
     * @param bool $includeCustom   Include the custom module language files
     *
     * @return mixed false on error or void
     */
    public function do_export($language = null, $includeCore = false, $includeCustom = false)
    {
        if (empty($language)) {
            $this->error = 'No language file chosen.';
            return false;
        }

        $all_lang_files = list_lang_files($language);
        if (! count($all_lang_files)) {
            $this->error = 'No files found to archive.';
            return false;
        }

        // Make the zip file
        $this->load->library('zip');
        foreach ($all_lang_files as $key => $file) {
            if (is_numeric($key) && $includeCore) {
                $content = load_lang_file($file, $language);
                $this->zip->add_data($file, save_lang_file($file, $language, $content, true));
            } elseif (($key == 'core' && $includeCore)
                      || ($key == 'custom' && $includeCustom)
            ) {
                foreach ($file as $f) {
                    $content = load_lang_file($f, $language);
                    $this->zip->add_data($f, save_lang_file($f, $language, $content, true));
                }
            }
        }

        $this->zip->download("app_{$language}_files.zip");
        die();
    }


    //--------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------

 }
