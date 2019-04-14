<?php
class M_service_detail extends CI_Model
{
	function insert_detail($id_master, $id_barang, $jumlah_beli, $harga_satuan, $sub_total)
	{
		$dt = array(
			'id_service_m' => $id_master,
			'id_barang	' => $id_barang,
			'jumlah_beli' => $jumlah_beli,
			'harga_satuan' => $harga_satuan,
			'total' => $sub_total
		);

		return $this->db->insert('pj_service_detail', $dt);
	}

	function get_detail($id_service)
	{
		$sql = "
			SELECT 
				b.`kode_barang`,  
				b.`nama_barang`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga_satuan`, 0),',','.') ) AS harga_satuan, 
				a.`harga_satuan` AS harga_satuan_asli, 
				a.`jumlah_beli`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`total`, 0),',','.') ) AS sub_total,
				a.`total` AS sub_total_asli  
			FROM 
				`pj_service_detail` a 
				LEFT JOIN `pj_barang` b ON a.`id_barang` = b.`id_barang` 
			WHERE 
				a.`id_service_m` = '".$id_service."' 
			ORDER BY 
				a.`id_service_d` ASC 
		";

		return $this->db->query($sql);
	}
}