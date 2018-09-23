<?php

class Product_Model {
  private $_tablePrefix = 'I2OUikH_';

  public function FetchProductData(){
    global $wpdb;
    $sql = "
        SELECT
          ".$this->_tablePrefix."posts.post_title AS title,
          ".$this->_tablePrefix."posts.guid AS url,
          GROUP_CONCAT(".$this->_tablePrefix."terms.name ) AS cats,
          img_posts.guid AS img,
          t2.meta_value AS price,
          ".$this->_tablePrefix."posts.post_content AS content
        FROM ".$this->_tablePrefix."term_relationships
        JOIN ".$this->_tablePrefix."posts
          ON ".$this->_tablePrefix."posts.ID = ".$this->_tablePrefix."term_relationships.object_id
        LEFT JOIN (SELECT term_taxonomy_id AS extra_id, object_id FROM ".$this->_tablePrefix."term_relationships ) AS tax_1
          ON ".$this->_tablePrefix."term_relationships.object_id = tax_1.object_id
        LEFT JOIN ".$this->_tablePrefix."terms
          ON ".$this->_tablePrefix."terms.term_id = tax_1.extra_id
        LEFT JOIN ".$this->_tablePrefix."postmeta AS t1
          ON ".$this->_tablePrefix."posts.ID = t1.post_id
          AND t1.meta_key = '_thumbnail_id'
        LEFT JOIN ".$this->_tablePrefix."posts AS img_posts
          ON img_posts.ID = t1.meta_value
        LEFT JOIN ".$this->_tablePrefix."postmeta AS t2
          ON ".$this->_tablePrefix."posts.ID = t2.post_id
          AND t2.meta_key = '_price'
        WHERE ".$this->_tablePrefix."posts.post_status = 'publish' AND ".$this->_tablePrefix."posts.post_type = 'product'
    ";
    if (!empty($_POST['search'])){
        $sql .= ' AND '.$this->_tablePrefix.'posts.post_title LIKE "%'.$_POST['search'].'%"';
    }
    if (isset($_POST['cats'])){
        $in = "'".implode("','", $_POST['cats'])."'";
        $sql .= ' AND '.$this->_tablePrefix.'terms.name IN ('.$in.')';
    }
    if (!empty($_POST['order'])){
        $sql .= ' ORDER BY '.$_POST['order'];
    }
    $sql .= ' GROUP BY '.$this->_tablePrefix.'posts.ID;';

    return $wpdb->get_results($sql, ARRAY_A);
  }
}
