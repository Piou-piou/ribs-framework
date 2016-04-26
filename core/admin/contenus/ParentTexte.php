<?php
	namespace core\admin\contenus;
	trait ParentTexte {
		private $parent_texte;
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getParentTexte($parent) {
			$dbc = \core\App::getDb();

			$query = $dbc->select("titre")->from("page")->where("ID_page", "=", $parent)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) $this->parent_texte = $obj->titre;
			}

			return $this->parent_texte;
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}