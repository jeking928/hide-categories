<?php
/**
 * functions_hideCategories.php
 * hideCategories
 * @copyright Copyright 2006 s_mack
 * @copyright Portions Copyright 2003-2006 Zen Cart Development Team
 */
////
  function HC_get_categories($categories_array = '', $parent_id = '0', $indent = '', $status_setting = '') {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();

    // show based on status
    if ($status_setting != '') {
      $zc_status = " c.categories_status='" . (int)$status_setting . "' and ";
    } else {
      $zc_status = '';
    }

    $categories_query = "select c.categories_id, cd.categories_name, c.categories_status
                         from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                         where " . $zc_status . "
                         parent_id = '" . (int)$parent_id . "'
                         and c.categories_id = cd.categories_id
                         and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                         order by sort_order, cd.categories_name";

    $categories = $db->Execute($categories_query);

    while (!$categories->EOF) {
		$mycid = split('_', $categories->fields['categories_id']);
		$categories_id = array_pop($mycid);
		$hide_status = $db->Execute("select visibility_status 
								FROM " . TABLE_HIDE_CATEGORIES . "
								WHERE categories_id = " . $categories_id . "
								LIMIT 1");
		if ($hide_status->fields['visibility_status'] < 2) {
		  $categories_array[] = array('id' => $categories->fields['categories_id'],
									  'text' => $indent . $categories->fields['categories_name']);
	
		  if ($categories->fields['categories_id'] != $parent_id) {
			$categories_array = HC_get_categories($categories_array, $categories->fields['categories_id'], $indent . '&nbsp;&nbsp;', '1');
		  }
		}
      $categories->MoveNext();
    }

    return $categories_array;
  }
?>