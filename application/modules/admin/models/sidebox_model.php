<?php

class Sidebox_model extends CI_Model
{
	public function add($data)
	{
		$this->db->insert("sideboxes", $data);

		$query = $this->db->query("SELECT id FROM sideboxes ORDER BY id DESC LIMIT 1");
		$row = $query->result_array();

		$this->db->query("UPDATE sideboxes SET `order`=? WHERE id=?", array($row[0]['id'], $row[0]['id']));
	}

	public function edit($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('sideboxes', $data);
	}

	public function delete($id)
	{
		$this->db->query("DELETE FROM sideboxes WHERE id=?", array($id));
	}

	public function addCustom($text)
	{
		$query = $this->db->query("SELECT id FROM sideboxes ORDER BY id DESC LIMIT 1");

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			$data = array(
				'sidebox_id' => $row[0]['id'],
				'content' => $text
			);

			$this->db->insert("sideboxes_custom", $data);
		}
	}

	public function editCustom($id, $text)
	{
		if($this->db->query("SELECT sidebox_id FROM sideboxes_custom WHERE sidebox_id=?", array($id))->num_rows())
		{
			$this->db->where('sidebox_id', $id);
			$this->db->update('sideboxes_custom', array('content' => $text));
		}
		else
		{
			$data = array(
				'sidebox_id' => $id,
				'content' => $text
			);

			$this->db->insert("sideboxes_custom", $data);
		}
	}

	public function getSidebox($id)
	{
		$query = $this->db->query("SELECT * FROM sideboxes WHERE id=? LIMIT 1", array($id));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0];
		}
		else
		{
			return false;
		}
	}

	public function getCustomText($id)
	{
		$query = $this->db->query("SELECT content FROM sideboxes_custom WHERE sidebox_id=? LIMIT 1", array($id));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0]['content'];
		}
		else
		{
			return "";
		}
	}

	public function getOrder($id)
	{
		$query = $this->db->query("SELECT `order` FROM sideboxes WHERE `id`=? LIMIT 1", array($id));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0]['order'];
		}
		else
		{
			return false;
		}
	}

	public function getPreviousOrder($order)
	{
		$query = $this->db->query("SELECT `order`, id FROM sideboxes WHERE `order` < ? ORDER BY `order` DESC LIMIT 1", array($order));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0];
		}
		else
		{
			return false;
		}
	}

	public function getNextOrder($order)
	{
		$query = $this->db->query("SELECT `order`, id FROM sideboxes WHERE `order` > ? ORDER BY `order` ASC LIMIT 1", array($order));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0];
		}
		else
		{
			return false;
		}
	}

	public function setOrder($id, $order)
	{
		$this->db->query("UPDATE sideboxes SET `order`=? WHERE `id`=? LIMIT 1", array($order, $id));
	}
}