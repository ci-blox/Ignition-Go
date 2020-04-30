<?php defined('BASEPATH') || exit('No direct script access allowed');

/** * API Controller * * Base Controller for API module * */
class API_Controller extends MX_Controller
{
    const HTTP_SUCCESS = 200;

    const HTTP_NO_CONTENT = 204;
    const HTTP_AMBIGUOUS = 300;
    const HTTP_REDIRECTED = 302;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;
    const HTTP_NOT_ALLOWED = 405;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;

    // 	Combined paramters from:
    // 	1. GET parameter (query string from URL)
    // 	2. POST body (from form data)
    // 	3. POST body (from JSON body)
    protected $mParams;

    // 	Constructor
    public function __construct()
    {
        parent::__construct();

        $this->load->model('users/user_model');
        $this->load->library('securinator/Auth');

        $this->verify_token();
        $this->parse_request();
    }

    // 	verify_token
    // 	Verify access token (e.g. API Key, JSON Web Token)
    protected function verify_token()
    {

		// 		TODO: implement API Key or JWT handling
        $this->current_user = NULL;

        // $valid === $this->auth->login(
		// 		$this->input->post('username'),
		// 		$this->input->post('password'),
		// 		0
		// )
    }

    // 	verify_method
    // 	Verify request method
    protected function verify_method($method, $error_response = NULL, $error_code = HTTP_NOT_FOUND)
    {
        $meth = $this->input->method(TRUE);
        if ($meth != strtoupper($method)) {
            if ($error_response === NULL) {
                $this->to_error_method_not_allowed();
            } else {
                $this->render_json($error_response, $error_code);
            }
        }
    }

    // 	verify_permission
    // 	Verify user access
    protected function verify_permission($perm, $error_response = NULL, $error_code = HTTP_NOT_FOUND)
    {
        if (empty($this->current_user) || (!$this->Auth->has_permission(strtolower($perm)))) {
            if ($error_response === NULL) {
                $this->to_error_unauthorized();
            } else {
                $this->render_json($error_response, $error_code);
            }
        }
    }

    // 	parse_request
    // 	Parse request to obtain request info (method, body)
    protected function parse_request()
    {

		// 		GET parameters
        $params = $this->input->get();

        // 		request body
        $meth = $this->input->method(TRUE);
        if (in_array($meth, array('POST', 'PUT'))) {
            $content_type = $this->input->server('CONTENT_TYPE');

            $is_form_request = ($content_type == 'application/x-www-form-urlencoded');

            $is_json_request = ($content_type == 'application/json' || $content_type == 'application/json; charset=UTF-8');

            if ($is_form_request) {

				// 	check CodeIgniter input
                $form_data = $this->input->post();

                if (!empty($form_data)) {

					// 	save parameters from form body
                    $params = array_merge($params, $form_data);
                } else {

					// 	query string from text body
                    $data = file_get_contents('php://input');

                    parse_str($data, $temp);

                    $params = array_merge($params, $temp);
                }
            } elseif ($is_json_request) {

				// 	JSON from text body
                $data = file_get_contents('php://input');

                if (!empty($data)) {
                    $params = array_merge($params, json_decode(trim($data), TRUE));
                }
            }
        }

        $this->mParams = array();
        //	sanitize  $mParams
        foreach ($params as $key => $value) {
            $this->mParams[$key] = sanitizeString($value);
        }
    }

    // render json
    public function render_json($response, $statuscode = '200')
    {
        $this->output
        ->set_status_header($statuscode)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
        exit;
    }

    // 	param
    // 	shortcut method to get single value from parameters
    protected function param($key, $default_val = NULL)
    {
        if (empty($this->mParams[$key])) {
            return $default_val;
        } else {
            return $this->mParams[$key];
        }
    }

    /**
     * Basic RESTful endpoints.
     *
     * For instance, the following URL patterns will be consumed by Items controller
     * 	[GET] /items					=> get_items()
     * 	[GET] /items/{id}				=> get_item(id)
     * 	[GET] /items/{id}/{subitem}		=> get_subitems(id, subitem)
     * 	[POST] /items 					=> create_item()
     * 	[POST] /items/{id}/{subitem}	=> create_subitem(id, subitem)
     * 	[PUT] /items/{id}				=> update_item(id)
     * 	[DELETE] /items/{id}			=> remove_item(id)	 *
     * Other custom endpoints can be added into the child controller instead, e.g.:
     * 	[GET] /items/hello 				=> should call hello() function inside Items controller	 */
    public function index()
    {
        $item_id = $this->uri->rsegment(3);

        $subitem = strtolower($this->uri->rsegment(4));

        switch ($this->input->method(TRUE)) {

			case 'GET':
			if (!empty($subitem)) {
			    $this->get_subitems($item_id, $subitem);
			} elseif (!empty($item_id)) {
			    $this->get_item($item_id);
			} else {
			    $this->get_items();
			}

			break;

			case 'POST':
			if (!empty($item_id) && !empty($subitem)) {
			    $this->create_subitem($item_id, $subitem);
			} elseif (empty($item_id)) {
			    $this->create_item();
			} else {
			    $this->to_error_not_found();
			}

			break;

			case 'PUT':
			if (!empty($item_id)) {
			    $this->update_item($item_id);
			} else {
			    $this->to_error_not_found();
			}

			break;

			case 'DELETE':
			if (!empty($item_id)) {
			    $this->remove_item($item_id);
			} else {
			    $this->to_error_not_found();
			}

			break;

			default:
			$this->to_error_not_found();

			break;

		}
    }

    /**	 * Functions to be override by child controllers	 */
    protected function get_items()
    {
        $this->to_not_implemented();
    }

    protected function get_item($id)
    {
        $data = array('item_id' => (int) $id);

        $this->to_not_implemented($data);
    }

    protected function get_subitems($parent_id, $subitem)
    {
        $data = array(
            'parent_id' => (int) $parent_id,
            'subitem' => $subitem,
        );

        $this->to_not_implemented($data);
    }

    protected function create_item()
    {
        $data = array('params' => $this->mParams);

        $this->to_not_implemented($data);
    }

    protected function create_subitem($parent_id, $subitem)
    {
        $data = array(
            'parent_id' => (int) $parent_id,
            'subitem' => $subitem,
        );

        $this->to_not_implemented($data);
    }

    protected function update_item($id)
    {
        $data = array(
            'item_id' => (int) $id,
            'params' => $this->mParams,
        );

        $this->to_not_implemented($data);
    }

    protected function remove_item($id)
    {
        $data = array('item_id' => (int) $id);

        $this->to_not_implemented($data);
    }

    /**	 * Wrapper functions to return responses
     * Reference: http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html	 */
    protected function to_response($data)
    {
        $this->render_json($data);
    }

    protected function to_created()
    {
        $data = array('message' => 'Created');

        $this->render_json($data, 201);
    }

    protected function to_accepted()
    {
        $data = array('message' => 'Accepted');

        $this->render_json($data, 201);
    }

    /**
     * Wrapper function to return error	 */
    protected function to_error($msg = 'An error occurs', $code = HTTP_SUCCESS, $additional_data = array())
    {
        $data = array('error' => $msg);

        // 		(optional) append additional data
        if (!empty($additional_data)) {
            $data['data'] = $additional_data;
        }

        $this->render_json($data, $code);
    }

    protected function to_error_bad_request()
    {
        $this->to_error('Bad Request', HTTP_BAD_REQUEST);
    }

    protected function to_error_unauthorized()
    {
        $this->to_error('Unauthorized', HTTP_UNAUTHORIZED);
    }

    protected function to_error_forbidden()
    {
        $this->to_error('Forbidden', HTTP_FORBIDDEN);
    }

    protected function to_error_not_found()
    {
        $this->to_error('Not Found', HTTP_NOT_FOUND);
    }

    protected function to_error_method_not_allowed()
    {
        $this->to_error('Method Not Allowed', HTTP_NOT_ALLOWED);
    }

    protected function to_not_implemented($additional_data = array())
    {

		// 		show "not implemented" info only during development mode
        if (ENVIRONMENT == 'development') {
            $trace = debug_backtrace();

            $caller = $trace[1];

            $data['url'] = current_url();

            $data['controller'] = $this->mCtrler;

            $data['function'] = $caller['function'];

            $data = array_merge($data, $additional_data);

            $this->to_error('Not Implemented', 501, $data);
        } else {
            $this->to_error_not_found();
        }
    }
}

/* end API_Controller */
