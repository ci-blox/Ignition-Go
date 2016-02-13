<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Cli Controller
 *
 * Controller to be called from CLI (command line) only
 * References: http://www.codeigniter.com/user_guide/general/cli.html
 *
 *
 * Command: php index.php cli [methodname]
 */
class Cli extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		//Check if is called from CLI
		if(!$this->input->is_cli_request())
		{
			//Not called from CLI
			
			//Log or report (Optional)
			
			//Error message or 404 (Optional)
			//echo "No access!";
			show_404();
			
			//Exit (Recommended)
			exit;
		}
	}
	
	// Run daily cron job
	// Command: php index.php cli daily
	public function daily()
	{
		echo 'Starting daily cron job'.PHP_EOL;
		$this->backup_db();
		echo 'End of daily cron job.'.PHP_EOL;
	}

	// Run backup operation of database
	// Command: php index.php cli backup_db
    // uses CI Database Utilities Class
    // TODO use config settings
	public function backup_db()
	{
		$this->load->dbutil();        
		$this->load->helper('file');

		// Options: http://www.codeigniter.com/user_guide/database/utilities.html?highlight=csv#setting-backup-preferences
		$prefs = array('format' => 'txt');

		echo '====== Task: Backup database'.PHP_EOL;
		$backup = $this->dbutil->backup($prefs);
		$file_path_1 = FCPATH.'../sql/backup/'.date('Y-m-d_H-i-s').'.sql';
		echo ' - '.$file_path_1.PHP_EOL;        
		$file_path_2 = FCPATH.'../sql/latest.sql';
		write_file($file_path_1, $backup);
		write_file($file_path_2, $backup);

		echo 'Database saved to these files: '.PHP_EOL;
		echo ' - '.$file_path_1.PHP_EOL;
		echo ' - '.$file_path_2.PHP_EOL;
		echo '====== Task: Backup database (Completed)'.PHP_EOL;
	}

    //
	// Empty any database tables 
	// Command: php index.php cli clean_db
	public function clean_db()
	{
		$this->load->database();

		echo '====== Task: Empty database'.PHP_EOL;
		//$this->db->truncate('xxxxx');
 		echo '====== Task: Empty database (Completed)'.PHP_EOL;
	}

	// Backup only the critical core tables
	public function save_core_db()
	{
        echo '====== Task: Backup core database'.PHP_EOL;
        $this->load->dbutil();
		$this->load->helper('file');
		$prefs = array('format' => 'txt');
		
		// Users
		$prefs['tables'] = array('users','users_meta');
		$backup = $this->dbutil->backup($prefs);
		$file_path = FCPATH.'sql/core/users_bk.sql';
		write_file($file_path, $backup);
		echo 'Database users saved to: '.$file_path.PHP_EOL;
		
		// Example: Blog
		//$prefs['tables'] = array('blog_posts', 'blog_categories', 'blog_tags', 'blog_post_tag_rel');
		//$backup = $this->dbutil->backup($prefs);
		//$file_path = FCPATH.'sql/core/blog.sql';
		//write_file($file_path, $backup);
		//echo 'Database saved to: '.$file_path.PHP_EOL;
	   echo '====== Task: Backup core database'.PHP_EOL;
    }
	
	// Reset database to last backup (i.e. from /sql/latest.sql)
	// Command: php index.php cli reset_db
	public function reset_db()
	{
		echo '====== Task: Reset database'.PHP_EOL;
		echo 'To be implemented'.PHP_EOL;
		echo '====== Task: Reset database (completed)'.PHP_EOL;
	}

	// Migrate database
	// Command: php index.php cli migrate
	public function migrate()
	{
		echo '====== Task: Migrate database'.PHP_EOL;
		echo 'To be implemented'.PHP_EOL;
        echo '====== Task: Migrate database (completed)'.PHP_EOL;
	}
}