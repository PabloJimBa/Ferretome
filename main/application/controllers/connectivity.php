<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


define('INFINITE', pow(2, (20 * 8 - 2)-1));

class Connectivity extends CI_Controller {

	private $data;
	
	
	/**
	 * Distances array
	 * @var array
	 */
	private $dist = array(array());
	/**
	 * Predecessor array
	 * @var array
	 */
	private $pred = array(array());
	
	/**
	 * Temporary table for various stuff.
	 * @var array
	 */
	private $tmp = array();
	
	

	public function __construct()
	{
		parent::__construct();

		$this->load->database('default');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('login');
		
		//$this->load->library('journal');


		//require_login();
		if (islogged()) $this->data['logintoken'] = TRUE;
		
		$this->load->model('pages_model','pagem',TRUE);
		
		if (($qida = $this->pagem->get_page('header_page')) != FALSE){
		
			$this->data['header_page'] = substr($qida, 3,-4);
		
		}
	}

	function index() {
		
		$this->data['extraHeader'] = '<script type="text/javascript" src="js/autocomplete.js"></script>';
		$this->data['extraHeader'] .= '<script type="text/javascript" src="js/connectivity.js"></script>';
		

		$this->data['action'] = 'index';
		$this->load->view('connectivity_view',$this->data);

		
	}
	
	function cat_connectivity_with_ferret_brain(){
		
		$this->data['action'] = 'cat_conn_with_ferret';
		
		$this->load->view('connectivity_view',$this->data);
		
		
	}
	
	
	
	
	function _modFloyd($rcMatrix) {
		
		$blist = array();
		$blist2 = array();
		$blist3 = array();
		
		
		
		
		foreach ($rcMatrix as $i => $vali) {
		
			$blist[$i] = '-';
		
		}
		
		$blist2 = $blist;
		$blist3 = $blist;
		
		foreach ($blist as $i => $vali) {
			foreach ($blist2 as $j => $valj) {
				
				if ( $i == $j ) {
					$this->dist[$i][$j] = 0;
				} else if ($rcMatrix[$i][$j] > 0 ) {
					$this->dist[$i][$j] = $rcMatrix[$i][$j];
				} else {
					$this->dist[$i][$j] = 999999;
				}
				$this->pred[$i][$j] = $i;
				
			}
		}
		
		foreach ($blist as $i => $vali) {
			foreach ($blist2 as $j => $valj) {
				foreach ($blist3 as $k => $valk) {
					
					
					if ($rcMatrix[$j][$k] == "-") $rcMatrix[$j][$k] = 999999;
					if ($rcMatrix[$j][$i] == "-") $rcMatrix[$j][$i] = 999999;
					if ($rcMatrix[$i][$k] == "-") $rcMatrix[$i][$k] = 999999;
					
					
					
					$rcMatrix[$j][$k] = min($rcMatrix[$j][$k],$rcMatrix[$j][$i] + $rcMatrix[$i][$k]);
					
															
					if ($this->dist[$i][$j] > ($this->dist[$i][$k] + $this->dist[$k][$j])) {
						$this->dist[$i][$j] = $this->dist[$i][$k] + $this->dist[$k][$j];
						$this->pred[$i][$j] = $this->pred[$k][$j];
					}
					
					//echo $j." ".$k."<-" .$rcMatrix[$j][$k]."||".  $rcMatrix[$j][$i] + $rcMatrix[$i][$k]."\n";
					
				}
			}
			
		}
		
		return $rcMatrix;
		
	}
	
	/**
	 * This function solves relation for two areas A and C in three area step A B C by two given relation between A and B, B and C 
	 * @param integer $a first relation code.
	 * @param integer $b second relation code.
	 * @return interger 
	 */
	function _getRCsol($a,$b){
		
		$codeLogic = array(array());
		
		$codeLogic[1][1] = 1;
		$codeLogic[1][2] = 2;
		$codeLogic[1][3] = 3;
		$codeLogic[1][4] = 4;
		
		$codeLogic[2][1] = 2;
		$codeLogic[2][2] = 2;
		$codeLogic[2][3] = '-';
		$codeLogic[2][4] = '-';
		
		$codeLogic[3][1] = 3;
		$codeLogic[3][2] = '-';
		$codeLogic[3][3] = 3;
		$codeLogic[3][4] = 4;
		
		$codeLogic[4][1] = 4;
		$codeLogic[4][2] = 4;
		$codeLogic[4][3] = '-';
		$codeLogic[4][4] = '-';
		
		return $codeLogic[$a][$b];		
		
				
	}
	
	
	function _popRcMatrix($rcMatrix,$pathM){
		
		$blist = array();
		$blist2 = array();
		
		$rcTemp = $rcMatrix;
		
		
		foreach ($rcMatrix as $i => $vali) {
		
			$blist[$i] = '-';
		
		}
		
		$blist2 = $blist;
		
		$unKnown = array();
		
		
		foreach ($blist as $i => $vali) {
			foreach ($blist2 as $j => $valj) {
				
				if ($i != $j) {
					// if path exists but not def in rc matrix then we need to add 
					if ($pathM[$i][$j] < 999999 && $rcMatrix[$i][$j] == '-' ) {
						
						$path = $this->_get_path($i,$j);
						
						//echo 'The sortest path from '.$i.' to '.$j.' is: <strong>';
						$str = '';
						
						$aN = count($path);
						
						$rPath = array();
						
						
						
						for ($a=0; $a<$aN; $a++) {
							
							
							$str .= $path[$a]. '->';
							
							if ($a+1 < $aN){
								$str .= $rcMatrix[$path[$a]][$path[$a+1]].'->';
								$rPath[$a] = $rcMatrix[$path[$a]][$path[$a+1]];
								
							}
							
							
						}
						//print_r($rPath);
						$prRel = '';
						
						for ($a=0; $a<$aN-1; $a++) {
							
							if ($a == 0) {
								
								$prRel = $rPath[$a];
								
								continue;
								
							}
							
							$prRel = $this->_getRCsol($prRel,$rPath[$a]);
							
							if ($prRel == '-') break;
							
							
							
						}
						
						
						// finally using calculated rc code
						$rcTemp[$i][$j] = $prRel;
						
						// if i is identical to j then j is identical to i, and the same for Smaller Larger and Overlap

						if ($prRel == 1) {
							
							$rcTemp[$j][$i] = 1; 
						
						} elseif ($prRel == 2) {
							
							$rcTemp[$j][$i] = 3;
							
						} elseif ($prRel == 3) {
							
							$rcTemp[$j][$i] = 2;
							
						} elseif ($prRel == 4) {
							
							$rcTemp[$j][$i] = 4;
							
						}
						

						
						
						//$str = substr($str, 0,-2);

						//echo $str. '</strong> solution <strong>'.$prRel.'</strong><br/>'."\n";
						//temporary just to check making all found rel as "I" ie "1"
						//$rcTemp[$i][$j] = 1;
						//$rcTemp[$j][$i] = 1;
						
						
						
						
					}
					
					
				}
				
				
			}
		}
		
		
		return $rcTemp;		
		
		
		
	}
	
	
	function _pintMatrix($matrix){
		
		$this->data['matrix'] = $matrix;
		
		$this->load->view('draw_simple_matrix_view',$this->data);
		
		unset($this->data['matrix']);

		
		
		
	}
	
	
	function trtest(){
		
		
		$rcMatrix = array();
		
		$pathM = array();
		
		
		// init matrix with all possible connections
		$rcMatrix = $this->_getRcMatrix();
			
		//determing paths using floyd-warshal algo
			
		$pathM = $this->_modFloyd($rcMatrix);
			
			
			
		//now find path and adding hidden relations to rcmatrix
			
			
		$rcMatrix = $this->_popRcMatrix($rcMatrix,$pathM);
		
		
		
	}
	
	
	function outputConnectivity (){
		/*
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$tstart = $mtime;
		*/
		$lid = $this->input->get('lid');
		
		//$lid = 12;
		//$lid = 7;
		
		$this->data['state'] = -1;

		//two demensional matrix[a][b] where a and b aronyms id  
		$bsMatrix = array();
		//list of all bsites in this bmap key=>value where key aronyms id and value is type of a the bsite (nuclues or cortical) 
		$bsList = array();
		//list of key => val where arc_id => acr_name
		$aList = array();
		//
		$rcMatrix = array();
		
		$pathM = array();
		
		// keeps connections reaon in format bs a , bs b  = value (array of reasons) where reason can be acronym map or paper own connectivity or transformation result
		$cReason = array(array());
		
		
		
		if (!empty($lid)) {
			
			$this->load->model('Connectivity_model','cnmod',TRUE);
			
//			if (($qida = $this->cnmod->get_connectivity($lid)) != FALSE) {

			if ($lid == -999){
				
				
				
				$rowa = $qida->row();
				
				echo $rowa->content;
				
				
				
			} else {
				// nothing in data base for this paper? ok let's create new
						
			
			
			
				$this->data['state'] = 0;
			
				$this->load->model('Maps_model','bmmod',TRUE);
				
				if (($qida = $this->bmmod->get_from_l($lid)) != FALSE) {
					
					$this->data['state'] = 1;
					
					$rowa = $qida->row();
					
					$mid = $rowa->brain_maps_id;
					 
					
					
					$this->load->model('Brainsite_model','bsmod',TRUE);
					
					if (($qida = $this->bsmod->get_for_map($mid)) != FALSE) {
					
						$this->data['state'] = 2;
						
						// generating list of all bsites in given bmap
						//$bsList = $this->_genSitesList($qida);
						$bsList = $this->_genList($qida);
						
						//print_r($bsList);
		
						// init matrix with all possible connections
						$bsMatrix = $this->_initMatrix($bsList);
						
						//collecting acronyms 
						
						$aList = $this->_genAcronList($qida);
						
						//getting rc matrix of all brain sites in db
						$rcMatrix = $this->_getRcMatrix();
						
						//determing paths using floyd-warshal algo
						
						$pathM = $this->_modFloyd($rcMatrix);
						
						
						
						//now recon path and adding hidden relations to rcmatrix 
						
						//$this->_pintMatrix($rcMatrix);
						
						//$this->_pintMatrix($pathM);
						
						
						$rcMatrix = $this->_popRcMatrix($rcMatrix,$pathM);
						
						//$this->_pintMatrix($rcMatrix);
						
						
						// and now collecting connectivity based on acronym equality 
						//first collecting all outcomes
						$this->db->join('injections','injections.injections_id = injections_and_outcomes.injections_id');
						$this->db->join('brain_sites','brain_sites.brain_sites_id = injections.brain_sites_id');
						$this->db->join('brain_site_acronyms','brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
																
						$qida = $this->db->get('injections_and_outcomes');
						
						//then collecting all labeled bsites inside this outcomes
						
						if ($qida->num_rows() > 0){
								
								
							foreach ($qida->result() as $rowa) {
						
								// now collecting all bsites where tracer spreaded
						
								$this->db->join('brain_sites','brain_sites.brain_sites_id = labelled_sites.brain_sites_id');
								$this->db->join('brain_site_acronyms','brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
						
						
								$qidb = $this->db->get_where('labelled_sites',array('outcome_id'=>$rowa->outcome_id));
						
								if ($qidb->num_rows() > 0){
										
										
									foreach ($qidb->result() as $rowb) {
										
										
										
										//mapping everything we know into a selected bmap using euquality of acronyms
										//checking if we have this acronyms in our bmap 
										
										
										if (isset($aList[$rowa->brain_site_acronyms_id]) && isset($aList[$rowb->brain_site_acronyms_id])) {
											//selecting bsite from acronyms array
											$asite = $aList[$rowa->brain_site_acronyms_id]['bsiteid'];
											$bsite = $aList[$rowb->brain_site_acronyms_id]['bsiteid'];
	
											//if so then we can insert presence of connection into matrix
											$bsMatrix[$asite][$bsite] = $rowb->labelled_sites_density;
											//$bsMatrix[$bsite][$asite] = $rowb->labelled_sites_density;
											
											$cReason[$asite][$bsite] = '- = null
1 = weak
2 = moderate
3 = strong';
											
										}
										
										
										
										// now mapping using relations codes
										
										//collecting relation of a_bsite with target map
	
										$arel = array();
										$brel = array();
										//collecting all relation of first b site
										if (isset($rcMatrix[$rowa->brain_sites_id])) {
											
											//print_r($rcMatrix[$rowa->brain_sites_id]);
											
											foreach ($rcMatrix[$rowa->brain_sites_id] as $bskey => $bsval) {
												
												
												if ($rowa->brain_sites_id != $bskey && $bsval !=  "-" && $bsval != "2" && $bsval != "4") {
	
													
												
													if (isset($bsList[$bskey])) {
														
														$arel[$bskey] = $bsval;
														
														echo $rowa->brain_sites_id. ' is ' .$bsval. ' than' . $bskey."<br/>";
													
													
													}
												}
												
											}
											
										}
										
										//collecting relation of b_bsite with target map
										
										if (isset($rcMatrix[$rowb->brain_sites_id])) {
										
											foreach ($rcMatrix[$rowb->brain_sites_id] as $bskey => $bsval) {
													
													
												if ($rowb->brain_sites_id != $bskey && $bsval != "-" && $bsval != "2" && $bsval != "4") {
										
														
													if (isset($bsList[$bskey])) {
															
														$brel[$bskey] = $bsval;
										
										
													}
												}
													
											}
										
										}
										
										
										
										if (!empty($arel) && !empty($brel)) {
											
											
											
											foreach ($arel as $keya=>$vala) {
												
												foreach ($brel as $keyb=>$valb) {
													
													if ($keya != $keyb) {
														
														$bsMatrix[$keya][$keyb] = $rowb->labelled_sites_density;
														//$bsMatrix[$keyb][$keya] = $rowb->labelled_sites_density;
														$cReason[$asite][$bsite] = 'transformation';
														
													}
													
													
													
												}
												
												
											}
											
											
										}
	
										//print_r($arel);
										//print_r($brel);
										
										 
										
										
										
										
										
						
									}
										
								}
						
							}
								
						}
						
						//saving results into a global varialbels 
						$this->data['matrix'] = $bsMatrix;
						
						$this->data['aname'] = $aList;
						
						$this->data['blist'] = $bsList;
						
						$this->data['explanation']= $cReason;
						
						
											
						//print_r($bsMatrix);
						//print_r($aList);
						
						
						
						
						
						
						
					
					}
				
					
				
				}
				
				
				
				$content = $this->load->view('draw_matrix_view',$this->data,TRUE);
				
				$this->cnmod->add($lid,$content);
				
				echo $content;
				
				
				
			}// end of else 
			
		}
		
		
		//outputing
		
		
		/*
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$tend = $mtime;
		$rtime = ($tend - $tstart);
		
		echo $rtime;
		*/
		
		
		
		
		
		
		
	}
	
	function getExplanation(){
		
		$bsa = $this->input->get('bsa');	
		$bsb = $this->input->get('bsb');
		
		if (!empty($bsa) && !empty($bsb)) {
			
			echo "explanation";
			
		}
	}
	
	function _genList($qida){
		
		$bsList = array();
		
		foreach ($qida->result() as $rowa){
				
			$bsList[$rowa->brain_sites_id] = array ("acr_id"=>$rowa->brain_sites_acronyms_id,"stype"=>$rowa->brain_sites_type_name);
				
		}
		
		
		return $bsList;
		
		
		
	}
	
	function _genSitesList($qida){
		
		$bsList = array();
		
		foreach ($qida->result() as $rowa){
			
			$bsList[$rowa->brain_sites_acronyms_id] = $rowa->brain_sites_type;
			
		}
		
		
		return $bsList;
		
		
	}
	
	
	function _genAcronList($qida){
		
		$bsList = array();
		
		foreach ($qida->result() as $rowa){
				
			$bsList[$rowa->brain_sites_acronyms_id] = array("aname"=>$rowa->acronym_full_name,"bsiteid"=>$rowa->brain_sites_id);
				
		}
		
		
		return $bsList;
		
		
		
		
	}
	
	function _initMatrix($bsList){
		
		
		$bsMatrix = array();
		$bsList2 = $bsList;
		
		foreach ($bsList as $key => $val) {
			
			foreach ($bsList2 as $key2 => $val2) {
			
			$bsMatrix[$key][$key2] = "-";
			
			}
			
		}
		
		return $bsMatrix;
		
		
		
	}
	
	function _getRcMatrix() {
		
		$rc = array();
		$bsList = array();
		
		$this->load->model('Mapsrelations_model','mrmod',TRUE);
		
		if (($qida = $this->mrmod->get_all()) != FALSE) {
			//collecting a list of all bsites 
			foreach ($qida->result() as $rowa) {
				
				$bsList[$rowa->brain_sites_id_a] = 0;
				$bsList[$rowa->brain_sites_id_b] = 0;
				
			}
			
			// init matrix 
			$rc = $this->_initMatrix($bsList);
			
			//and now populating with relations
			foreach ($qida->result() as $rowa) {
			
				$rc[$rowa->brain_sites_id_a][$rowa->brain_sites_id_b] = $rowa->maps_relations_code;

				if ($rowa->maps_relations_code == 1 || $rowa->maps_relations_code == 4) {
					
					$rc[$rowa->brain_sites_id_b][$rowa->brain_sites_id_a] = $rowa->maps_relations_code;
					
					
				} elseif ($rowa->maps_relations_code == 2) {
					
					$rc[$rowa->brain_sites_id_b][$rowa->brain_sites_id_a] = 3;
					
				} elseif ($rowa->maps_relations_code == 3) {
					
					$rc[$rowa->brain_sites_id_b][$rowa->brain_sites_id_a] = 2;
					
				}
			
			}
			
			//go back
			
			return $rc;
			
			
			
		}
		
		
		
	}
	
	private function __get_path($i, $j) {
	
		if ( $i != $j ) {
			$this->__get_path($i, $this->pred[$i][$j]);
		}
		array_push($this->tmp, $j);
	}
	
	/**
	 * Public function to access get path information.
	 *
	 * @param ingeger $i Starting node.
	 * @param integer $j End node.
	 * @return array Return array of nodes.
	 */
	public function _get_path($i, $j) {
		$this->tmp = array();
		$this->__get_path($i, $j);
		return $this->tmp;
	}
	
	
	

}
?>
