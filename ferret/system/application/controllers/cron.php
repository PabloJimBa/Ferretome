<?php

class Cron extends Controller {

	private $data;
	
	function Cron(){
		
		parent::Controller();
	
		$this->load->database('default');
		//$this->load->helper('form');
		//$this->load->library('session');
		$this->load->database('default');
		
		
	}
	
	
	
	
	function getmatrix() {
	
	
		$pass = $this->input->get('pass');
	
		if ($pass != 'aabb') exit;
		
		
		
		// collecting all bsites for where injection were made
		$this->db->join('injections','injections.injections_id = injections_and_outcomes.injections_id');
		$this->db->join('brain_sites','brain_sites.brain_sites_id = injections.brain_sites_id');
		$this->db->join('brain_site_acronyms','brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
		
		$this->db->join('brain_sites_types','brain_sites_types.brain_sites_type_id = brain_sites.brain_sites_type');
		
		$qida = $this->db->get('injections_and_outcomes');
		
		$aMatrix = array();
		
		$bMatrix = array();
		
		$aList = array();
		
		$typeList = array();
		
		
		if ($qida->num_rows() > 0){
			
			
			foreach ($qida->result() as $rowa) {
				
				// now collecting all bsites where tracer spreaded 
				
				$this->db->join('brain_sites','brain_sites.brain_sites_id = labelled_sites.brain_sites_id');
				$this->db->join('brain_site_acronyms','brain_site_acronyms.brain_site_acronyms_id = brain_sites.brain_sites_acronyms_id');
				$this->db->join('brain_sites_types','brain_sites_types.brain_sites_type_id = brain_sites.brain_sites_type');
				
				$qidb = $this->db->get_where('labelled_sites',array('outcome_id'=>$rowa->outcome_id));
				
				if ($qidb->num_rows() > 0){
					
					
					foreach ($qidb->result() as $rowb) {
						
						$aList[$rowa->brain_site_acronyms_id] = 0;
						$aList[$rowb->brain_site_acronyms_id] = 0;
						
						$typeList[$rowa->brain_site_acronyms_id] = $rowa->brain_sites_type_name;
						$typeList[$rowb->brain_site_acronyms_id] = $rowb->brain_sites_type_name;
						
						$bMatrix[$rowa->brain_site_acronyms_id][$rowb->brain_site_acronyms_id] = $rowb->labelled_sites_density;
						$bMatrix[$rowb->brain_site_acronyms_id][$rowa->brain_site_acronyms_id] = $rowb->labelled_sites_density;
						
						
					}
					
					
					
					
				}
				
				
				
			}
			
			
			
		}
		
		$this->load->model('Acronyms_model','acrmod',TRUE);
		
		foreach ($aList as $key=>$val) {
			
			
			$aList[$key] = $this->acrmod->get_for_id($key);
			
			
			
			
		}
		
		$aList2 = $aList;
		
		// init all intersection of all posible connection with "-"
		foreach ($aList as $bsite1=>$val1) {
			foreach ($aList2 as $bsite2=>$val2) {
		
				$aMatrix[$bsite1][$bsite2] = "-";
				
				
		
			}
		}
		
		//print_r($aMatrix);
		// now populating this matrix wiht exitting connections
		foreach ($bMatrix as $bsite1=>$val1) {
			foreach ($val1 as $bsite2=>$val2) {
		
				$aMatrix[$bsite1][$bsite2] = $val2;
		
		
		
			}
		}
		
		
		//print_r($aList);
		
		//print_r($bMatrix);
		
		//print_r($aMatrix);
		
		/*
		echo "<table border='1'><tr><td>-</td>";
		
		
		// printing head of the table
		
		foreach ($aMatrix as $k1=>$v1) {
				
			echo "<td>".$aList[$k1]."</td>";
		
				
		}
		
		
		echo "</tr>";
		
		
		// second approach
		
		foreach ($aList as $bsite1=>$val1) {
				
			echo "<tr><td>".$aList[$bsite1]."</td>";
				
			foreach ($aList as $bsite2=>$val2) {
		
				echo "<td>".$aMatrix[$bsite1][$bsite2]."</td>";
		
		
		
			}
		}
		
		
		// closing table
		echo "</table>";
		*/
		
		$str = '';
		
		$fp= fopen(md5(time())."csv", "w+");
			
		
		$str .= "-,-,";
		
		
		
		
		// printing head of the table, first type bsite subcortica and etc
		
		foreach ($aMatrix as $k1=>$v1) {
		
			$str .= $typeList[$k1].",";
		
		
		}
		
		$str .= "\n";
		
		$str .= "-,-,";
		//printing head of the table, now acronym
		foreach ($aMatrix as $k1=>$v1) {
		
			$str .= $aList[$k1].",";
		
		
		}
		
		
		$str .= "\n";
		
		
		// second approach
		
		foreach ($aList as $bsite1=>$val1) {
		
			$str .= $typeList[$bsite1].",".$aList[$bsite1].",";
		
			foreach ($aList as $bsite2=>$val2) {
		
				$str .= $aMatrix[$bsite1][$bsite2].",";
		
			}
			
			$str .= "\n";
			
		}
		
		
		// closing table
		
		fputs($fp, $str, strlen($str));
		
		fclose($fp);
		
	
	
	
	}


	function remap() {
		
		
		$pass = $this->input->get('pass');
		
		if ($pass != 'dndnjhj') exit;
		
		
		
		
		$aMatrix = array();
		
		$acMat = array();
		
		$acProj = array();
		
		$N = 0;
		// open file and colleting all acronyms of bsites
		$fp = fopen("fac.csv", "r");
		
		while (!feof($fp)) {
			
			
			$str = stream_get_line($fp, 1024, "\n");
			
			$temp = explode(",", $str);
			
			//print_r($temp);
			
			
			//$acMat[$N++] = $temp[0];
			
			$acMat[$temp[0]] = 1;
			$acMat[$temp[1]] = 1;
			
			
			
			
			
			
			
			
		}
		
		
		fclose($fp);
		
		//echo count($acMat);
		
		//print_r($acMat);
		
		
		$acMat2 = array();
		
		
		$acMat2 = $acMat;
		
		
		
		foreach ($acMat as $bsite1=>$val1) {
			foreach ($acMat2 as $bsite2=>$val2) {
				
				$aMatrix[$bsite1][$bsite2] = "-";
				
			}
		}
		
		//print_r($aMatrix);
		
		
		/*
		 * wrong
		 * 
		// init adjacency matrix with that acronyms
		$N -=1;
		
		for ($s=0; $s<=$N; $s++) {
			
			for($m=0; $m<=$N; $m++) {
				
				
				$aMatrix[$acMat[$s]][$acMat[$m]] = "-";
				
				
			}
			
			
		}
		*/
		
		// open file again and populate adj matrix with weights 
		$fp = fopen("fac.csv", "r");
		
		while (!feof($fp)) {
				
				
			$str = stream_get_line($fp, 1024, "\n");
				
			$temp = explode(",", $str);
				
			//print_r($temp);
				
				
			$aMatrix[$temp[0]][$temp[1]] = $temp[2];
				
				
				
				
		}
		
		fclose($fp);
		
		
		
		//print_r($aMatrix);
		
		
		echo "<table border='1'><tr><td>-</td>";
		
				
		// printing head of the table
		
		foreach ($aMatrix as $k1=>$v1) {
			
			echo "<td>".$k1."</td>";
						
			
		}
		
		
		echo "</tr>";
		
				
		// second approach
		
		foreach ($acMat as $bsite1=>$val1) {
			
			echo "<tr><td>".$bsite1."</td>";
			
			foreach ($acMat as $bsite2=>$val2) {
				
				echo "<td>".$aMatrix[$bsite1][$bsite2]."</td>";
		
				
		
			}
			
			echo "</tr>";
			
		}
		
		
		// closing table				
		echo "</table>";
		
				
		
		
	}


}
?>