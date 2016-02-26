<?php
    namespace core\form;

    class FormValidator {
        private $datas = [];
        private $errors = [];


        //-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
        public function __construct($datas) {
            $this->datas = $datas;
        }
        //-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//


        //-------------------------- GETTER ----------------------------------------------------------------------------//
        public function Check($name, $rule, $option=null) {
            $validator = "validate".ucfirst($rule);

            if (!$this->$validator($name, $option)) {
                $this->errors[$name] = "Le champ $name n'a pas été rempli correctement";
            }
        }

        public function getErrors() {
            if (!empty($this->errors)) {
                $errors = "<ul>";
                foreach ($this->errors as $error) {
                    $errors .= "<li>".$error."</li>";
                }
                $errors .= "</ul>";

                return $errors;
            }
        }
        //-------------------------- FIN GETTER ----------------------------------------------------------------------------//


        //-------------------------- SETTER ----------------------------------------------------------------------------//
        public function validateRequired($name) {
            return array_key_exists($name, $this->datas) && $this->datas[$name] != "";
        }

        public function validateEmail($name) {
            return array_key_exists($name, $this->datas) && filter_var($this->datas[$name], FILTER_VALIDATE_EMAIL);
        }
        //-------------------------- FIN SETTER ----------------------------------------------------------------------------//
    }