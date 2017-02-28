<?php
class ControllerModuleIpcheck extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/ipcheck'); // Loading the language file of ipcheck
 
    $this->document->setTitle($this->language->get('heading_title')); // Set the title of the page to the heading title in the Language file i.e., ipcheck
 
    $this->load->model('tool/ipcheck'); // Load the Setting Model  (All of the OpenCart Module & General Settings are saved using this Model )
 
 
 
    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { // Start If: Validates and check if data is coming by save (POST) method
        $this->model_tools_ipcheck->addIpcheck($this->request->post);      // Parse all the coming data to Setting Model to save it in database.
 
        $this->session->data['success'] = $this->language->get('text_success'); // To display the success text on data save
 
        $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')); // Redirect to the Module Listing
    } // End If
 
    /*Assign the language data for parsing it to view*/
    $this->data['heading_title'] = $this->language->get('heading_title');
 
    $this->data['text_enabled'] = $this->language->get('text_enabled');
    $this->data['text_disabled'] = $this->language->get('text_disabled');
    $this->data['text_content_top'] = $this->language->get('text_content_top');
    $this->data['text_content_bottom'] = $this->language->get('text_content_bottom');     
    $this->data['text_column_left'] = $this->language->get('text_column_left');
    $this->data['text_column_right'] = $this->language->get('text_column_right');
 
    $this->data['entry_code'] = $this->language->get('entry_code');
    $this->data['entry_country'] = $this->language->get('entry_country');
    $this->data['entry_language'] = $this->language->get('entry_language');
    $this->data['entry_currency'] = $this->language->get('entry_currency');
    $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
 
    $this->data['button_save'] = $this->language->get('button_save');
    $this->data['button_cancel'] = $this->language->get('button_cancel');
    $this->data['button_add_module'] = $this->language->get('button_add_module');
    $this->data['button_remove'] = $this->language->get('button_remove');
     
 
    /*This Block returns the warning if any*/
    if (isset($this->error['warning'])) {
        $this->data['error_warning'] = $this->error['warning'];
    } else {
        $this->data['error_warning'] = '';
    }
    /*End Block*/
 
    /*This Block returns the error code if any*/
    if (isset($this->error['code'])) {
        $this->data['error_code'] = $this->error['code'];
    } else {
        $this->data['error_code'] = '';
    }
    /*End Block*/
 
 
    /* Making of Breadcrumbs to be displayed on site*/
    $this->data['breadcrumbs'] = array();
 
    $this->data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        'separator' => false
    );
 
    $this->data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_module'),
        'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
        'separator' => ' :: '
    );
 
    $this->data['breadcrumbs'][] = array(
        'text'      => $this->language->get('heading_title'),
        'href'      => $this->url->link('module/ipcheck', 'token=' . $this->session->data['token'], 'SSL'),
        'separator' => ' :: '
    );
 
    /* End Breadcrumb Block*/
 
    $this->data['action'] = $this->url->link('module/ipcheck', 'token=' . $this->session->data['token'], 'SSL'); // URL to be directed when the save button is pressed
 
    $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'); // URL to be redirected when cancel button is pressed
 
     
    /* This block checks, if the ipcheck text field is set it parses it to view otherwise get the default ipcheck text field from the database and parse it*/
 
  
    /* End Block*/
 
    $this->data['modules'] = array();
 
    /* This block parses the Module Settings such as Layout, Position,Status & Order Status to the view*/
    if (isset($this->request->post['ipcheck_module'])) {
        $this->data['modules'] = $this->request->post['ipcheck_module'];
    } elseif ($this->config->get('ipcheck_module')) {
        $this->data['modules'] = $this->config->get('ipcheck_module');
    }
    /* End Block*/         
  // Getting all the Layouts available on system
    
    $this->load->model('localisation/country');
    
    $this->data['countries'] = $this->model_localisation_country->getCountries();
    
    $this->load->model('localisation/language');
    
    $this->data['languages'] = $this->model_localisation_language->getLanguages();
    
    $this->load->model('localisation/currency');
    
    $this->data['currencies'] = $this->model_localisation_currency->getCurrencies();
    
 
    $this->template = 'module/ipcheck.tpl'; // Loading the ipcheck.tpl template
    $this->children = array(
        'common/header',
        'common/footer'
    );  // Adding children to our default template i.e., ipcheck.tpl
 
    $this->response->setOutput($this->render()); // Rendering t
	}

	protected function validate() {
		/* Block to check the user permission to manipulate the module*/
        if (!$this->user->hasPermission('modify', 'module/ipcheck')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        /* End Block*/
 
        /* Block to check if the ipcheck_text_field is properly set to save into database, otherwise the error is returned*/
       
        /* End Block*/
 
        /*Block returns true if no error is found, else false if any error detected*/
        if (!$this->error) {
            return true;
        } else {
            return false;
        }   	
	}
}
?>
