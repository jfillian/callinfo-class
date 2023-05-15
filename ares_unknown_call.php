<?php
/**
 * MIT License
 * 
 * Copyright (c) 2023 jfillian, KC9UNZ
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * Description of ares_unknown_call
 *
 * @author Jeff, KC9UNZ
 * kc9unz@arrl.net
 */
class ares_unknown_call {

	private $status;
	private $callsign;
        private $licenseclass;
	private $name;
	private $fname;
	private $lname;
	private $address_line1;
	private $address_line2;
	private $address_city;
	private $address_state;
	private $address_zip;

        public function __construct($call){
            $jsonurl = "https://callook.info/" . $call . "/json";
            $jsonstring = file_get_contents($jsonurl);
            $jsoncall = json_decode($jsonstring,true);
            $this->set_status($jsoncall["status"]) ;            
            if ($this->get_status() == "VALID") {
                $this->set_callsign($jsoncall["current"]["callsign"]);
                $this->set_licenseclass($jsoncall["current"]["operClass"]);
                $this->set_name($jsoncall["name"]);
                $this->set_address_line1($jsoncall["address"]["line1"]);
                $this->set_address_line2($jsoncall["address"]["line2"]);
            } else {
                $this->set_callsign($call);
            }
       }
        
        public function check_values(){
            echo $this->get_status() . "\n";
            echo $this->get_callsign() . "\n";
            echo $this->get_licenseclass() . "\n";
            echo $this->get_name() . "\n";
            echo $this->get_address_line1() . "\n";
            echo $this->get_address_line2() . "\n";
            echo $this->get_fname() . "\n";
            echo $this->get_lname() . "\n";
            echo "address1: " . $this->get_address_line1() . "\n";
            echo "address2: " . $this->get_address_line2() . "\n";
            echo "city: " . $this->get_address_city() . "\n";
            echo "state: " . $this->get_address_state() . "\n";
            echo "zip: " .  $this->get_address_zip() . "\n";
            }
        
	/**
	* Returns status
	*/
	public function get_status(){
		return $this->status;
	}

	/**
	* Returns callsign
	*/
	public function get_callsign(){
		return $this->callsign;
	}

	/**
	* Returns licenseclass
	*/
	public function get_licenseclass(){
		return $this->licenseclass;
	}

	/**
	* Returns name
	*/
	public function get_name(){
		return $this->name;
	}

	/**
	* Returns fname
	*/
	public function get_fname(){
		return $this->fname;
	}

	/**
	* Returns lname
	*/
	public function get_lname(){
		return $this->lname;
	}

	/**
	* Returns address_line1
	*/
	public function get_address_line1(){
		return $this->address_line1;
	}

	/**
	* Returns address_line2
	*/
	public function get_address_line2(){
		return $this->address_line2;
	}

	/**
	* Returns address_city
	*/
	public function get_address_city(){
		return $this->address_city;
	}

	/**
	* Returns address_state
	*/
	public function get_address_state(){
		return $this->address_state;
	}

	/**
	* Returns address_zip
	*/
	public function get_address_zip(){
		return $this->address_zip;
	}

	/**
	* Sets status
	*/
	public function set_status(string $value ){
		$this->status = $value;
	}

	/**
	* Sets callsign
	*/
	public function set_callsign(string $value ){
		$this->callsign = $value;
	}
        
	/**
	* Sets licenseclass
	*/
	public function set_licenseclass(string $value ){
		$this->licenseclass = $value;
	}

	/**
	* Sets name
	*/
	public function set_name(string $value ){
		$this->name = trim($value);
                //$NameLength = mb_strlen($this->name);
                $last_space = strrpos($this->name, " ");
                //$end_of_string = gmp_neg($NameLength - $last_space);
                $this->set_fname(trim(substr($this->name,0, $last_space)));
                $this->set_lname(trim(substr($this->name, $last_space)));
	}

        /**
	* Sets fname
	*/
	public function set_fname(string $value ){
		$this->fname = $value;
	}

	/**
	* Sets lname
	*/
	public function set_lname(string $value ){
		$this->lname = $value;
	}

	/**
	* Sets address_line1
	*/
	public function set_address_line1(string $value ){
		$this->address_line1 = $value;
	}

	/**
	* Sets address_line2
	*/
	public function set_address_line2(string $value ){
		$this->address_line2 = trim($value);
                
                //$NameLength = mb_strlen($this->name);
                $last_space = strrpos($this->address_line2, " ");
                $this->set_address_zip(trim(substr($this->address_line2, $last_space)));
                $comma = strpos($this->address_line2, ",");

                $this->set_address_city(trim(substr($this->address_line2,0, $comma)));
                $this->set_address_state(trim(substr($this->address_line2, ($comma + 2),2)));
	}

	/**
	* Sets address_city
	*/
	public function set_address_city(string $value ){
		$this->address_city = $value;
	}

	/**
	* Sets address_state
	*/
	public function set_address_state(string $value ){
		$this->address_state = $value;
	}

	/**
	* Sets address_zip
	*/
	public function set_address_zip(string $value ){
		$this->address_zip = $value;
	}

	/**
	* Shows status on profile Page
	*/
	public function show_status(){
		$this->status = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="status">status</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="status"';
		$val = $val . '                   name="status"';
		$val = $val . '                   value="' . $this->get_status() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows callsign on profile Page
	*/
	public function show_callsign(){
		$this->callsign = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="callsign">callsign</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="callsign"';
		$val = $val . '                   name="callsign"';
		$val = $val . '                   value="' . $this->get_callsign() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows name on profile Page
	*/
	public function show_name(){
		$this->name = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="name">name</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="name"';
		$val = $val . '                   name="name"';
		$val = $val . '                   value="' . $this->get_name() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows fname on profile Page
	*/
	public function show_fname(){
		$this->fname = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="fname">fname</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="fname"';
		$val = $val . '                   name="fname"';
		$val = $val . '                   value="' . $this->get_fname() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows lname on profile Page
	*/
	public function show_lname(){
		$this->lname = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="lname">lname</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="lname"';
		$val = $val . '                   name="lname"';
		$val = $val . '                   value="' . $this->get_lname() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows address_line1 on profile Page
	*/
	public function show_address_line1(){
		$this->address_line1 = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="address_line1">address_line1</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="address_line1"';
		$val = $val . '                   name="address_line1"';
		$val = $val . '                   value="' . $this->get_address_line1() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows address_line2 on profile Page
	*/
	public function show_address_line2(){
		$this->address_line2 = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="address_line2">address_line2</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="address_line2"';
		$val = $val . '                   name="address_line2"';
		$val = $val . '                   value="' . $this->get_address_line2() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows address_city on profile Page
	*/
	public function show_address_city(){
		$this->address_city = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="address_city">address_city</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="address_city"';
		$val = $val . '                   name="address_city"';
		$val = $val . '                   value="' . $this->get_address_city() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows address_state on profile Page
	*/
	public function show_address_state(){
		$this->address_state = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="address_state">address_state</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="address_state"';
		$val = $val . '                   name="address_state"';
		$val = $val . '                   value="' . $this->get_address_state() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}

	/**
	* Shows address_zip on profile Page
	*/
	public function show_address_zip(){
		$this->address_zip = $value;
		$val = '';
		$val = $val . '<tr>';
		$val = $val . '        <th>';
		$val = $val . '            <label for="address_zip">address_zip</label>';
		$val = $val . '        </th>';
		$val = $val . '        <td>';
		$val = $val . '            <input type="text"';
		$val = $val . '                   id="address_zip"';
		$val = $val . '                   name="address_zip"';
		$val = $val . '                   value="' . $this->get_address_zip() . '"';
		$val = $val . '                   title="Add a title line">';
		$val = $val . '        </td>';
		$val = $val . '    </tr>';
		echo $val;
	}
    
}
