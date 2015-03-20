<?php
/**
 * Direktori Model
 */
namespace Model;

class DirektoriModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_list($alpha) {
		$r 		= array();
		$row	= array();
		$run 	= $this->db->query("SELECT ID_DIREKTORI, NAMA_DIREKTORI FROM direktori WHERE LEFT(UPPER(NAMA_DIREKTORI), 1) = '$alpha'");
		if ( ! empty($run)) {
			for ($i = 0; $i < count($run); $i++) {
				if ($i % 3 == 0 && $i != 0) {
					$r[]	= $row;
					$row	= array();
				}
				$row[] 	= array(
					'link'	=> $run[$i]->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '_', strtolower($run[$i]->NAMA_DIREKTORI)),
					'nama'	=> $run[$i]->NAMA_DIREKTORI	
				);
			}
			while (count($row) < 3) $row[] = array('link' => '', 'nama' => '');
			$r[] = $row;
		}
		return array(
			'type'		=> TRUE,
			'direktori'	=> $r
		);
	}
}