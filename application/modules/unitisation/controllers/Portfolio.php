<?php


/**
 * Description of Portfolio
 * manages portfolios
 * in the portfolio
 * @author itischarles
 */
class Portfolio extends MY_Controller{
    //put your code here
    private $userDetails;
    private $client_accessor;
    protected $auth_lib;
    
    /**
     * $moduleName
     * specify the name of this module
     * @var string 
     */
    private $moduleName = 'Unitisation';
    
    /**
     * $moduleKey
     * specify the module unique key
     * @var string 
     */
    private $moduleKey = 'unitisation-module';
    
    
    
    /**
     *$errorMessage
     * holds error messages. useful for methods colling themselves. get al the errors in one place
     * do not proceed in the called method in error
     * @var array 
     */
    private $errorMessage = array();
    
    
    
                        
    function __construct() {
        parent::__construct();

     
      $this->auth_lib = new Auth_lib();      
      $this->auth_lib->is_authenticated();
      // make sure this user has read access to this module
      $this->auth_lib->has_readAccess_orRedirect($this->moduleKey);
          
      
       

      $this->load->module('template');
      $this->load->model('Portfolio_model', 'portfolio_accessor'); 
      
    }
    
    
    
    
    function index(){
        
        
        $data['page_title'] = "Portfolios";
	$data['page_header'] = "Portfolio Dashboard";
        $data['content_view'] = "unitisation/portfolio-dashboard";
        $data['sidebar_view'] = "unitisation/unitisation_sidebar";
        $data['module'] = $this->moduleName;
         $this->breadcrumbs->push('Portfolios', '/unitisation/portfolio');
        $this->breadcrumbs->push('Dashboard', '/');
	
        
        $this->template->callDefaultTemplate($data);
    }
    
    
    
       
    
    function search(){
	
	
	
	$offset = ($this->input->get('offset')? $this->input->get('offset') : ''); 
	$per_page  = ($this->input->get('result_per_page')? $this->input->get('result_per_page') : 200);
		
	$config['base_url'] = base_url('portfolios');
	$config['total_rows'] = $data['db_total_rows'] = $this->portfolio_accessor->searchPortfolios(false, false,true);	
	$config['per_page']         = $per_page;
        $config['num_links']	    = 10; 
        $config['next_link']        = 'Next';
	$config['prev_link']        = 'Prev';
        $config['next_tag_open']    = '<li class="nextPage">';
        $config['next_tag_close']   = '</li>';
        
        $config['prev_tag_open']    = '<li class="prevPage">';
        $config['prev_tag_close']   = '</li>';
        $config['cur_tag_open']     = "<li class='active'><a>";
        $config['cur_tag_close']    = "</a></li>";	
	$config['full_tag_open']    =  '<ul class="pagination">';
	$config['full_tag_close']    = '</ul>';
	$config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['page_query_string'] = TRUE;
	$config['query_string_segment'] = "offset";
	$config['reuse_query_string']  = TRUE;
	
	
        $this->pagination->initialize($config); 
	
	$data['page_title'] = "Portfolios Overview";      
	$data['link_title'] = "portfolios";          
       
       
	$data['portfolios'] = $this->portfolio_accessor->searchPortfolios($per_page, $offset);
         
        
        $data['page_title'] = "Portfolios";
	$data['page_header'] = "Portfolio Overview";
        $data['content_view'] = "unitisation/portfolio-search";
        $data['sidebar_view'] = "unitisation/unitisation_sidebar";
        $data['module'] = $this->moduleName;
          $this->breadcrumbs->push('Portfolios', '/unitisation/portfolio');
        $this->breadcrumbs->push('Search', '/');
	    
        
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    function addNewPortfolio(){	   
         
        if($this->input->post('add_portfolio')):
            
	    $this->form_validation->set_rules('reference', 'Reference', 'trim|required|is_unique[unit_portfolios.portfolioReference]');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
          
	  
            $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
            
	if($this->form_validation->run()):
	    
            $content['portfolioAddedByUserID'] =  $this->current_userID;
            $content['portfolioReference'] = $this->input->post('reference');
            $content['portfolioName'] = $this->input->post('name');		 
            $content['portfolioDateAdded'] = changeDateFormat('now', "Y-m-d");
            $content['portfolioURL'] =  $portfolioURL = $this->generateElementURL('portfolio');


            $this->portfolio_accessor->addNew($content);


            $this->session->set_flashdata('message', 'Portfolio Added Successfully');
            $this->session->set_flashdata('type', 'flash_success');
           redirect(base_url('unitisation/portfolio/'.$portfolioURL.'/view')); 

            endif;
              
        endif;
        
	$data['page_title'] = "Add New Portfolio";
	$data['page_header'] = "Add New Portfolio";
        $data['content_view'] = "unitisation/portfolio-form";
        $data['sidebar_view'] = "unitisation/unitisation_sidebar";
        $data['mode'] = 'New';
        $data['module'] = $this->moduleName;
        $data['errorMessage'] = $this->errorMessage;
        
         $this->breadcrumbs->push('Portfolios', '/unitisation/portfolio');
        $this->breadcrumbs->push('New', '/');
	
        
        $this->template->callDefaultTemplate($data);
	
	
	
	
	
    }
    
    
    
    function editPortfolio($portfolioURL){
	
	$data['portfolio'] = $portfolio = $this->portfolio_accessor->getByURL($portfolioURL);
         
          if(empty($portfolio)):
             $this->session->set_flashdata('message', 'Record Not found!!!');
             $this->session->set_flashdata('type', 'flash_error');
             redirect($_SERVER['HTTP_REFERER']); 
        endif;
	
	
	  if($this->input->post('edit_portfolio')):
            
	    $is_unique = '';
	    if($this->input->post('reference') != $portfolio->portfolioReference):
		$is_unique = "|is_unique[unit_portfolios.portfolioReference]";
	    endif;
	      
	    $this->form_validation->set_rules('reference', 'Reference', 'trim|required'.$is_unique);            
	    $this->form_validation->set_rules('name', 'Name', 'trim|required');
          
	  
            $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
            
	    if($this->form_validation->run()):
	   
		$content['portfolioAddedByUserID'] =  $this->current_userID;
		$content['portfolioReference'] = $this->input->post('reference');
		$content['portfolioName'] = $this->input->post('name');		 
		$content['portfolioDateAdded'] = changeDateFormat('now', "Y-m-d");
		$content['portfolioURL'] =  $portfolioURL = $this->generateElementURL('portfolio');


		$this->portfolio_accessor->updatePortfolio($content, array('portfolioID'=>$portfolio->portfolioID));

                      
		$this->session->set_flashdata('message', 'Record updated Successfully');
		$this->session->set_flashdata('type', 'flash_success');
	       redirect(base_url('unitisation/portfolio/'.$portfolioURL.'/view')); 

            endif;
              
        endif;
         
	$data['page_title'] = $portfolio->portfolioName;
	$data['page_header'] = $portfolio->portfolioName." : Update";
        $data['content_view'] = "unitisation/portfolio-form";
        $data['sidebar_view'] = "unitisation/unitisation_sidebar";
        $data['mode'] = 'Edit';
        $data['module'] = $this->moduleName;
        // breadcrum
        $this->breadcrumbs->push('Portfolios', '/unitisation/portfolio');
        $this->breadcrumbs->push($portfolio->portfolioName, 'unitisation/portfolio/'.$portfolioURL.'/view');
	$this->breadcrumbs->push('Edit', '/');
        
        
        $this->template->callDefaultTemplate($data);
	
	
    }
    
    
    function viewPortfolio($portfolioURL){
	
	 $data['portfolio'] = $portfolio = $this->portfolio_accessor->getByURL($portfolioURL);
         
         
         
        if(empty($portfolio)):
             $this->session->set_flashdata('message', 'Record Not found!!!');
             $this->session->set_flashdata('type', 'flash_error');
             redirect($_SERVER['HTTP_REFERER']); 
        endif;

        // $data['page_title'] = strtoupper($portfolio->portfolioReference);  
     
        
        
        $data['page_title'] = $portfolio->portfolioName;
	$data['page_header'] = $portfolio->portfolioName." : View";
        $data['content_view'] = "unitisation/portfolio-view";
        $data['sidebar_view'] = "unitisation/unitisation_sidebar";
          $data['module'] = $this->moduleName;   
        // breadcrum
        $this->breadcrumbs->push('Portfolios', '/unitisation/portfolio');
        $this->breadcrumbs->push($portfolio->portfolioName, '/');
	
        
        $this->template->callDefaultTemplate($data);
    }
    
    
    
    /**
     * upload csv to ccreate new portfolios
     */
   
    function upload(){
	
        
        if($this->input->post('upload_portfolios')){   
           
            $this->form_validation->set_rules('file_ref2', 'Ref', 'required');
            if(empty($_FILES['upload_p']['name'])){
                $this->form_validation->set_rules('upload_p', 'File', 'required');
            } 
            
            $this->form_validation->set_error_delimiters( '<em class="error_text">','</em>' );
            
            if($this->form_validation->run()){
                                
                $csvData = file_get_contents($_FILES['upload_p']['tmp_name']);
                $lines = explode(PHP_EOL, $csvData);


                $head = str_getcsv(array_shift($lines));

               //remove empty line
                foreach($lines as $key=>$line){			
                    if(empty($line)){			
                        unset($lines[$key]);
                    }
                }

               //create a multidimentional array
                $content_array = array();
                foreach ($lines as $line) {
                    $content_array[] = array_combine($head, str_getcsv($line));
                }
	
                //use the multi-dimentioanl to create insert
                if(!empty($content_array)){

                    // prepare for batch insert
                    $batchInsert= array();

                    foreach ($content_array as $key=>$val){                    

                        //stop upload is any record already exist
                        $content['portfolioAddedByUserID'] =  $this->current_userID;
                        $content['portfolioReference'] = $reference= $val['reference'];
                        $content['portfolioName'] = $val['name']; 		 
                        $content['portfolioDateAdded'] = changeDateFormat('now', "Y-m-d");
                        $content['portfolioURL'] =  $portfolioURL = $this->generateElementURL('portfolio');

                        $batchInsert[] = $content; 


                        // test if this portfolio is unique
                        $isUnique =  $this->portfolio_accessor->checkIsUnique(array('portfolioReference'=>$reference));

                        if(intval($isUnique)>0){
                            $this->errorMessage[] = "Portfolio reference $reference already exist";			     
                        }
                    }// end foreach ($content_array as $key=>$val)
		    
                    if(empty($this->errorMessage) && (!empty($batchInsert))){

                       $this->portfolio_accessor->addInBatch($batchInsert);

                       $this->session->set_flashdata('message', 'file processed Successfully');
                       $this->session->set_flashdata('type', 'flash_success');
                       redirect(base_url('unitisation/portfolio/upload'));

                    }//#insert
                    
                }// end if $content_array
            } // end if run
              
        }// end if posted
     
 
        $this->addNewPortfolio();

    }
   
  
    
    /**
     * get the module specific javascription file link
     */
    function getModule_js(){
        return base_url('module_assets/'.$this->moduleName.'unitisation-module.js');
    }
    
}

