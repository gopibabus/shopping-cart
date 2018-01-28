<?php

class Categories
{
    private $Database;

    private $dbTable = 'categories';

    function __construct()
    {
        global $Database;
        $this->Database = $Database;
    }

///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////*Setters & Getters for Categories*///////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


    /**
     * Return array with category information
     * @param int $id
     * @return array
     */
    public function getCategories($id = null)
    {

        $data = [];
        if ($id != null) {
            //get specific category
            if ($stmt = $this->Database->
            prepare("SELECT id, name FROM " . $this->dbTable . " WHERE  id=? LIMIT 1;")) {

                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($catId, $catName);
                $stmt->fetch();

                if ($stmt->num_rows > 0) {
                    $data = array('id' => $catId, 'name' => $catName);
                }
                $stmt->close();
            }
        } else {
            //get all categories
            if ($result = $this->Database->query("SELECT * FROM " . $this->dbTable . " ORDER BY name;")) {

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                        $data[] = array('id' => $row['id'], 'name' => $row['name']);
                    }
                }
            }
        }
        return $data;
    }

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////*Create Page Parts*////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Returns unordered list of links to all category pages
     * @param string $active
     * @return string
     */
    public function createCategoryNav($active = null)
    {
        //get all categories
        $categories = $this->getCategories();

        //set up 'all' item

        $data = '<li ';
        if ($active == strtolower('home')) {
            $data .= ' class="active"';
        }
        $data .= '> <a href="' . SITE_PATH . '">View All</a></li>';

        //loop through each category
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $data .= '<li ';
                if (strtolower($active) == strtolower($category['name'])) {
                    $data .= 'class="active"';
                }
                $data .= '> <a href="' . SITE_PATH . 'index.php?id=' . $category['id'] . '">' .
                    $category['name'] . '</a></li>';
            }
        }

        return $data;
    }
}