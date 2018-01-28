<?php

/**
 *Template Class
 * Handle all templating tasks - display views, alerts, errors & view data
 */
class Template
{

    private $data;

    private $alertTypes = ['success', 'alert', 'error'];

    /**
     * Template constructor.
     */
    public function __construct()
    {
    }

    /**
     * Loads specified url
     *
     * @param string $url
     * @param string $title
     * @return null
     */
    public function load($url, $title = '')
    {
        if ($title != '') {
            $this->setData('pageTitle', $title);
        }
        include($url);
    }

    /**
     * Redirects to specified url
     *
     * @param string $url
     * @return null
     */
    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }


///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////*Setters & Getters*////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


    /**
     * Saves provided data for use by the view later
     *
     * @param string $name
     * @param string $value
     * @param bool $clean
     * @return  null
     */
    public function setData($name, $value, $clean = false)
    {

        if ($clean == true) {
            $this->data[$name] = htmlentities($value, ENT_QUOTES);
        } else {
            $this->data[$name] = $value;
        }

    }

    /**
     * Retrieves data based on provided name for access by view
     *
     * @param string $name
     * @param bool $echo
     * @return string
     */
    public function getData($name, $echo = true)
    {
        if (isset($this->data[$name])) {

            if ($echo) {
                echo $this->data[$name];
            } else {
                return $this->data[$name];
            }
        }
        return '';
    }

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////*GET & SET ALERTS*/////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Sets alert messages stored in session
     * @param string $value
     * @param string $type
     * @return null
     */
    public function setAlert($value, $type = 'success')
    {
        $_SESSION[$type][] = $value;
    }

    /**
     * Returns String containing multiple list items of alerts
     * @return string
     */
    public function getAlerts()
    {
        $data = '';
        foreach ($this->alertTypes as $alert) {
            if (isset($_SESSION[$alert])) {

                foreach ($_SESSION[$alert] as $value) {
                    $data .= '<li class="' . $alert . '">' . $value . '</li>';
                }
                unset($_SESSION[$alert]);
            }
        }
        echo $data;
    }
}