<?php
class ModelToolIpcheck extends Model {
	public function addIpcheck($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "Ipcheck SET country = '" . $this->db->escape($data['country']) . "', language = '" . $this->db->escape($data['language']) . "', currency = '" . $this->db->escape($data['currency']));

		$this->cache->delete('ipcheck');
	}

	public function editIpcheck($ipcheck_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "Ipcheck SET country = '" . $this->db->escape($data['country']) . "', language = '" . $this->db->escape($data['language']) . "', currency = '" . $this->db->escape($data['currency']). "' WHERE ipcheck_id = '" . (int)$ipcheck_id . "'");

		$this->cache->delete('ipcheck');
	}

	public function deleteIpcheck($ipcheck_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "Ipcheck WHERE ipcheck_id = '" . (int)$ipcheck_id . "'");

		$this->cache->delete('ipcheck');
	}

	public function getIpcheck($ipcheck_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "Ipcheck WHERE ipcheck_id = '" . (int)$ipcheck_id . "'");

		return $query->row;
	}

	public function getIpchecks($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "Ipcheck";

			$sort_data = array(
				'country',
				'language',
				'currency'
			);	

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY country";	
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}					

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}		

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$ipcheck_data = $this->cache->get('ipcheck');

			if (!$ipcheck_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "Ipcheck ORDER BY country ASC");

				$ipcheck_data = $query->rows;

				$this->cache->set('ipcheck', $ipcheck_data);
			}

			return $ipcheck_data;			
		}	
	}

	public function getTotalIpcheck() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "Ipcheck");

		return $query->row['total'];
	}	
}
?>
