<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class MY_Pagination extends CI_Pagination {

    public $container = 'page';
	var $cur_tag_open		= '<b style="margin-right:5px;font-size:15px;margin-left:5px;">';
	var $cur_tag_close		= '</b>';
	public $callback_ajax = 'hash_change';
	public $query_string = '';

    public function __construct()
    {
        parent::__construct();
    }
    
	public function create_links_ajax()
	{
        $CI =& get_instance(); 

		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
		   return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Determine the current page number.
		$CI =& get_instance();

		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != 0)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != 0)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}

		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}

		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

  		// And here we go...
		$output = '';
                
                // Check for separated controls
                if ($this->separate_controls)
                    $controls_output = '';

		// Render the "First" link
		if  ($this->cur_page > $this->num_links)
		{
			$output .= $this->first_tag_open.'<a class="pjax" href="'.$this->base_url.'offset'.'/'.$this->suffix.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->cur_page != 1)
		{
			$i = $uri_page_number - $this->per_page;
			if ($i == 0) $i = 'offset';
                        
                        if (!$this->separate_controls)
                            $output .= $this->prev_tag_open.'<a class="pjax" href="'.$this->base_url.$i.'/'.$this->suffix.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
                        else
                            $controls_output .= $this->prev_tag_open.'<a class="pjax" href="'.$this->base_url.$i.'/'.$this->suffix.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		}
                
                else {
                    if ($this->separate_controls)
                        $controls_output .= str_replace('>', ' class="disabled">', $this->prev_tag_open).'<span>'.$this->prev_link.'</span>'.$this->prev_tag_close;
                }

		// Write the digit links
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = ($loop * $this->per_page) - $this->per_page;

			if ($i >= 0)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$n = ($i == 0) ? 'offset' : $i;
					$output .= $this->num_tag_open.'<a class="pjax" href="'.$this->base_url.$n.'/'.$this->suffix.'">'.$loop.'</a>'.$this->num_tag_close;
				}
			}
		}

		// Render the "next" link
		if ($this->cur_page < $num_pages)
		{
                    if (!$this->separate_controls)
			$output .= $this->next_tag_open.'<a class="pjax" href="'.$this->base_url.($this->cur_page * $this->per_page).'/'.$this->suffix.'">'.$this->next_link.'</a>'.$this->next_tag_close;
                    else
                        $controls_output .= $this->next_tag_open.'<a class="pjax" href="'.$this->base_url.($this->cur_page * $this->per_page).'/'.$this->suffix.'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}
                
                else {
                    if ($this->separate_controls)
                        $controls_output .= str_replace('>', ' class="disabled">', $this->next_tag_open).'<span>'.$this->next_link.'</span>'.$this->next_tag_close;
                }

		// Render the "Last" link
		if (($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = (($num_pages * $this->per_page) - $this->per_page);
			$output .= $this->last_tag_open.'<a class="pjax" href="'.$this->base_url.$i.'/'.$this->suffix.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);
                
                // Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
                
                if ($this->separate_controls){
                    $controls_output = preg_replace("#([^:])//+#", "\\1/", $controls_output);
                    $controls_output = $this->controls_tag_open.$controls_output.$this->controls_tag_close;
                    
                    $output = $output.$controls_output;
                }

		return $output;
	}
	
	
	
		function create_links_modal()
	{
		if(Language::$lang == 'en'){
			$this->first_link = $this->first_link . lang('First', 'main');
            $this->last_link = lang('Last', 'main') . $this->last_link ;
		}
		else{
			$lang_main = Language::get_languages('main');
			$this->first_link = $lang_main['PAGINATION_FIRST'];
            $this->last_link = $lang_main['PAGINATION_LAST'] ;
	
		}
		
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
			return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Set the base page index for starting page number
		if ($this->use_page_numbers)
		{
			$base_page = 1;
		}
		else
		{
			$base_page = 0;
		}

		// Determine the current page number.
		$CI =& get_instance();

		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != $base_page)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != $base_page)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		
		// Set current page to 1 if using page numbers instead of offset
		if ($this->use_page_numbers AND $this->cur_page == 0)
		{
			$this->cur_page = $base_page;
		}

		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = $base_page;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->use_page_numbers)
		{
			if ($this->cur_page > $num_pages)
			{
				$this->cur_page = $num_pages;
			}
		}
		else
		{
			if ($this->cur_page > $this->total_rows)
			{
				$this->cur_page = ($num_pages - 1) * $this->per_page;
			}
		}

		$uri_page_number = $this->cur_page;
		
		if ( ! $this->use_page_numbers)
		{
			$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		}

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

		// And here we go...
		$output = '';
		
		

		// Render the "First" link
		if  ($this->first_link !== FALSE AND $this->cur_page > ($this->num_links + 1))
		{
			$first_url = ($this->first_url == '') ? $this->base_url : $this->first_url;
			if(substr($first_url,-1) == '/')
				$first_url .= '1';

			$output .= $this->first_tag_open.'<a '.$this->anchor_class.'href="'.$first_url.$this->query_string.'" onclick="'.$this->callback_ajax.'(this.href);return false;">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->prev_link !== FALSE AND $this->cur_page != 1)
		{
			if ($this->use_page_numbers)
			{
				$i = $uri_page_number - 1;
			}
			else
			{
				$i = $uri_page_number - $this->per_page;
			}

			if ($i == 0 && $this->first_url != '')
			{

				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.$this->query_string.'" onclick="'.$this->callback_ajax.'(this.href);return false;">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
			else
			{
				$i = ($i == 0) ? '' : $this->prefix.$i.$this->suffix;

				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$i.$this->query_string.'" onclick="'.$this->callback_ajax.'(this.href);return false;">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}

		}

		// Render the pages
		if ($this->display_pages !== FALSE)
		{
			// Write the digit links
			for ($loop = $start -1; $loop <= $end; $loop++)
			{
				if ($this->use_page_numbers)
				{
					$i = $loop;
				}
				else
				{
					$i = ($loop * $this->per_page) - $this->per_page;
				}

				if ($i >= $base_page)
				{
					if ($this->cur_page == $loop)
					{
						$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
					}
					else
					{
						$n = ($i == $base_page) ? '' : $i;

						if ($n == '' && $this->first_url != '')
						{

							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.$this->query_string.'" onclick="'.$this->callback_ajax.'(this.href);return false;">'.$loop.'</a>'.$this->num_tag_close;
						}
						else
						{
							$n = ($n == '') ? '' : $this->prefix.$n.$this->suffix;
							if(!$n)
								$n = 1;

							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$n.$this->query_string.'" onclick="'.$this->callback_ajax.'(this.href);return false;">'.$loop.'</a>'.$this->num_tag_close;
						}
					}
				}
			}
		}

		// Render the "next" link
		if ($this->next_link !== FALSE AND $this->cur_page < $num_pages)
		{
			if ($this->use_page_numbers)
			{
				$i = $this->cur_page + 1;
			}
			else
			{
				$i = ($this->cur_page * $this->per_page);
			}
			
			$output .= $this->next_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.$i.$this->suffix.$this->query_string.'" onclick="'.$this->callback_ajax.'(this.href);return false;">'.$this->next_link.'</a>'.$this->next_tag_close;
		}
		// Render the "Last" link
		if ($this->last_link !== FALSE AND ($this->cur_page + $this->num_links) < $num_pages)
		{
			if ($this->use_page_numbers)
			{
				$i = $num_pages;
			}
			else
			{
				$i = (($num_pages * $this->per_page) - $this->per_page);
			}
			$output .= $this->last_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.$i.$this->suffix.$this->query_string.'" onclick="'.$this->callback_ajax.'(this.href);return false;">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		return $output;
	}

}
