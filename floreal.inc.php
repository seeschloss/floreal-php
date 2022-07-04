<?php

class FlorealDate {
	private $_gregorian_date;

	function __construct($timestamp = NULL, $arg2 = NULL, $arg3 = NULL) {
		$this->_gregorian_date = new DateTime();

		if ($timestamp !== NULL and $arg2 === NULL and $arg3 === NULL) {
			$this->_gregorian_date->setTimestamp($timestamp);
		} else if (is_int($timestamp) and is_int($arg2) and is_int($arg3)) {
			$this->set_republican_date($timestamp, $arg2, $arg3);
		}
	}

	function timestamp() {
		return $this->_gregorian_date->getTimestamp();
	}

	function __toString() {
		return $this->to_full_date_string();
	}

	function to_short_date_string() {
		return "{$this->republican_day()}-{$this->republican_month()}-{$this->republican_year_roman()}";
	}

	function to_full_date_string() {
		return "{$this->republican_day()} {$this->republican_month_name()}, an {$this->republican_year_roman()}";
	}

	function republican_day_of_year() {
		$seconds = ($this->_gregorian_date->getTimestamp() - $this->first_day_of_year()->getTimestamp());

		return floor($seconds / (3600 * 24)) + 1;
	}

	function set_republican_date($republican_year, $republican_month, $republican_day) {
		$first_day_of_year = self::_first_day_of_year($republican_year);

		// Allow using 0 as the month for complementary days
		if ($republican_month == 0) {
			$republican_month = 13;
		}

		$day_of_republican_year = 30*($republican_month-1) + $republican_day;

		$this->_gregorian_date = $first_day_of_year->add(new DateInterval('P'.($day_of_republican_year - 1).'D'));
	}

	function republican_day_name() {
		if (!$this->is_complementary_day()) switch ($this->republican_day_of_decade()) {
			case 1: return "primidi";
			case 2: return "duodi";
			case 3: return "tridi";
			case 4: return "quartidi";
			case 5: return "quintidi";
			case 6: return "sextidi";
			case 7: return "septidi";
			case 8: return "octidi";
			case 9: return "nonidi";
			case 10: return "décadi";
		} else switch ($this->republican_day_of_decade()) {
			case 1: return "jour de la vertu";
			case 2: return "jour du génie";
			case 3: return "jour du travail";
			case 4: return "jour de l'opinion";
			case 5: return "jour des récompenses";
			case 6: return "jour de la révolution";
		}
	}

	function republican_day_title() {
		$day_names = [
			'',	// align with day numbers
			'raisin' => 'fruit',
			'safran' => 'condiment',
			'châtaigne' => 'fruit',
			'colchique' => 'fleur',
			'cheval' => 'mammifère',
			'balsamine' => 'fleur',
			'carotte' => 'légume',
			'amaranthe' => 'céréale',
			'panais' => 'légume',
			'cuve' => 'outil',
			'pomme de terre' => 'légume',
			'immortelle' => 'fleur',
			'potiron' => 'légume',
			'réséda' => 'fleur',
			'âne' => 'mammifère',
			'belle de nuit' => 'fleur',
			'citrouille' => 'légume',
			'sarrasin' => 'céréale',
			'tournesol' => 'céréale',
			'pressoir' => 'outil',
			'chanvre' => 'plante',
			'pêche' => 'fruit',
			'navet' => 'légume',
			'amaryllis' => 'fleur',
			'bœuf' => 'mammifère',
			'aubergine' => 'légume',
			'piment' => 'condiment',
			'tomate' => 'légume',
			'orge' => 'céréale',
			'tonneau' => 'outil',
			'pomme' => 'fruit',
			'céleri' => 'légume',
			'poire' => 'fruit',
			'betterave' => 'légume',
			'oie' => 'oiseau',
			'héliotrope' => 'fleur',
			'figue' => 'fruit',
			'scorsonère' => 'légume',
			'alisier' => 'arbre',
			'charrue' => 'outil',
			'salsifis' => 'légume',
			'mâcre' => 'légume',
			'topinambour' => 'légume',
			'endive' => 'légume',
			'dindon' => 'oiseau',
			'chervis' => 'comestible',
			'cresson' => 'comestible',
			'dentelaire' => 'officinale',
			'grenade' => 'fruit',
			'herse' => 'outil',
			'bacchante' => 'plante',
			'azerole' => 'arbre',
			'garance' => 'teinture',
			'orange' => 'fruit',
			'faisan' => 'oiseau',
			'pistache' => 'fruit',
			'macjonc' => 'légume',
			'coing' => 'fruit',
			'cormier' => 'arbre',
			'rouleau' => 'outil',
			'raiponce' => 'fleur',
			'turneps' => 'légume',
			'chicorée' => 'comestible',
			'nèfle' => 'légume',
			'cochon' => 'mammifère',
			'mâche' => 'légume',
			'chou-fleur' => 'légume',
			'miel' => 'comestible',
			'genièvre' => 'fruit',
			'pioche' => 'outil',
			'cire' => 'matiere',
			'raifort' => 'condiment',
			'cèdre' => 'arbre',
			'sapin' => 'arbre',
			'chevreuil' => 'mammifère',
			'ajonc' => 'plante',
			'cyprès' => 'arbre',
			'lierre' => 'plante',
			'sabine' => 'officinale',
			'hoyau' => 'outil',
			'érable sucré' => 'arbre',
			'bruyère' => 'plante',
			'roseau' => 'plante',
			'oseille' => 'légume',
			'grillon' => 'insecte',
			'pignon' => 'fruit',
			'liège' => 'arbre',
			'truffe' => 'condiment',
			'olive' => 'fruit',
			'pelle' => 'outil',
			'tourbe' => 'matière',
			'houille' => 'matière',
			'bitume' => 'matière',
			'soufre' => 'matière',
			'chien' => 'mammifère',
			'lave' => 'matière',
			'terre végétale' => 'matière',
			'fumier' => 'matière',
			'salpêtre' => 'matière',
			'fléau' => 'outil',
			'granit' => 'matière',
			'argile' => 'matière',
			'ardoise' => 'matière',
			'grès' => 'matière',
			'lapin' => 'mammifère',
			'silex' => 'matière',
			'marne' => 'matière',
			'pierre à chaux' => 'matière',
			'marbre' => 'matière',
			'van' => 'outil',
			'pierre à plâtre' => 'matière',
			'sel' => 'matière',
			'fer' => 'métal',
			'cuivre' => 'métal',
			'chat' => 'mammifère',
			'étain' => 'métal',
			'plomb' => 'métal',
			'zinc' => 'métal',
			'mercure' => 'métal',
			'crible' => 'outil',
			'lauréole' => 'teinture',
			'mousse' => 'plante',
			'fragon' => 'officinale',
			'perce-neige' => 'fleur',
			'taureau' => 'mammifère',
			'laurier tin' => 'arbre',
			'amadouvier' => 'plante',
			'mézéréon' => 'teinture',
			'peuplier' => 'arbre',
			'coignée' => 'outil',
			'ellébore' => 'officinale',
			'brocoli' => 'légume',
			'laurier' => 'arbre',
			'avelinier' => 'arbre',
			'vache' => 'mammifère',
			'buis' => 'arbre',
			'lichen' => 'plante',
			'if' => 'arbre',
			'pulmonaire' => 'officinale',
			'serpette' => 'outil',
			'thlaspi' => 'officinale',
			'thimele' => 'officinale',
			'chiendent' => 'plante',
			'traînasse' => 'teinture',
			'lièvre' => 'mammifère',
			'guède' => 'teinture',
			'noisetier' => 'arbre',
			'cyclamen' => 'fleur',
			'chélidoine' => 'teinture',
			'traîneau' => 'outil',
			'tussilage' => 'officinale',
			'cornouiller' => 'arbre',
			'violier' => 'officinale',
			'troène' => 'arbre',
			'bouc' => 'mammifère',
			'asaret' => 'officinale',
			'alaterne' => 'arbre',
			'violette' => 'fleur',
			'marceau' => 'arbre',
			'bêche' => 'outil',
			'narcisse' => 'fleur',
			'orme' => 'arbre',
			'fumeterre' => 'officinale',
			'vélar' => 'officinale',
			'chèvre' => 'mammifère',
			'épinard' => 'légume',
			'doronic' => 'officinale',
			'mouron' => 'plante',
			'cerfeuil' => 'condiment',
			'cordeau' => 'outil',
			'mandragore' => 'officinale',
			'persil' => 'condiment',
			'cochléaria' => 'officinale',
			'pâquerette' => 'fleur',
			'thon' => 'poisson',
			'pissenlit' => 'fleur',
			'sylvie' => 'fleur',
			'capillaire' => 'officinale',
			'frêne' => 'arbre',
			'plantoir' => 'outil',
			'primevère' => 'fleur',
			'platane' => 'arbre',
			'asperge' => 'légume',
			'tulipe' => 'fleur',
			'poule' => 'oiseau',
			'bette' => 'légume',
			'bouleau' => 'arbre',
			'jonquille' => 'fleur',
			'aulne' => 'arbre',
			'couvoir' => 'outil',
			'pervenche' => 'fleur',
			'charme' => 'arbre',
			'morille' => 'légume',
			'hêtre' => 'arbre',
			'abeille' => 'insecte',
			'laitue' => 'légume',
			'mélèze' => 'arbre',
			'ciguë' => 'officinale',
			'radis' => 'légume',
			'ruche' => 'outil',
			'gainier' => 'arbre',
			'romaine' => 'légume',
			'marronnier' => 'arbre',
			'roquette' => 'légume',
			'pigeon' => 'oiseau',
			'lilas' => 'fleur',
			'anémone' => 'fleur',
			'pensée' => 'fleur',
			'myrtile' => 'fruit',
			'greffoir' => 'outil',
			'rose' => 'fleur',
			'chêne' => 'arbre',
			'fougère' => 'plante',
			'aubépine' => 'arbre',
			'rossignol' => 'oiseau',
			'ancolie' => 'fleur',
			'muguet' => 'fleur',
			'champignon' => 'légume',
			'hyacinthe' => 'fleur',
			'râteau' => 'outil',
			'rhubarbe' => 'fruit',
			'sainfoin' => 'officinale',
			'bâton-d\'or' => 'fleur',
			'chamérisier' => 'fleur',
			'ver à soie' => 'insecte',
			'consoude' => 'officinale',
			'pimprenelle' => 'comestible',
			'corbeille d\'or' => 'fleur',
			'arroche' => 'légume',
			'sarcloir' => 'outil',
			'statice' => 'officinale',
			'fritillaire' => 'fleur',
			'bourrache' => 'officinale',
			'valériane' => 'officinale',
			'carpe' => 'poisson',
			'fusain' => 'officinale',
			'civette' => 'condiment',
			'buglosse' => 'officinale',
			'sénevé' => 'condiment',
			'houlette' => 'outil',
			'luzerne' => 'plante',
			'hémérocalle' => 'fleur',
			'trèfle' => 'plante',
			'angélique' => 'officinale',
			'canard' => 'oiseau',
			'mélisse' => 'officinale',
			'fromental' => 'plante',
			'lis martagon' => 'fleur',
			'serpolet' => 'condiment',
			'faux' => 'outil',
			'fraise' => 'fruit',
			'bétoine' => 'officinale',
			'pois' => 'légume',
			'acacia' => 'arbre',
			'caille' => 'oiseau',
			'œillet' => 'fleur',
			'sureau' => 'arbre',
			'pavot' => 'fleur',
			'tilleul' => 'arbre',
			'fourche' => 'outil',
			'barbeau' => 'fleur',
			'camomille' => 'officinale',
			'chèvrefeuille' => 'fleur',
			'caille-lait' => 'teinture',
			'tanche' => 'poisson',
			'jasmin' => 'fleur',
			'verveine' => 'officinale',
			'thym' => 'condiment',
			'pivoine' => 'fleur',
			'chariot' => 'outil',
			'seigle' => 'céréale',
			'avoine' => 'céréale',
			'oignon' => 'légume',
			'véronique' => 'fleur',
			'mulet' => 'mammifère',
			'romarin' => 'condiment',
			'concombre' => 'légume',
			'échalote' => 'condiment',
			'absinthe' => 'officinale',
			'faucille' => 'outil',
			'coriandre' => 'condiment',
			'artichaut' => 'légume',
			'girofle' => 'condiment',
			'lavande' => 'fleur',
			'chamois' => 'mammifère',
			'tabac' => 'officinale',
			'groseille' => 'fruit',
			'gesse' => 'légume',
			'cerise' => 'fruit',
			'parc' => 'outil',
			'menthe' => 'condiment',
			'cumin' => 'condiment',
			'haricot' => 'légume',
			'orcanète' => 'teinture',
			'pintade' => 'oiseau',
			'sauge' => 'condiment',
			'ail' => 'condiment',
			'vesce' => 'plante',
			'blé' => 'céréale',
			'chalemie' => 'outil',
			'épeautre' => 'céréale',
			'bouillon-blanc' => 'officinale',
			'melon' => 'fruit',
			'ivraie' => 'plante',
			'bélier' => 'mammifère',
			'prêle' => 'plante',
			'armoise' => 'officinale',
			'carthame' => 'teinture',
			'mûre' => 'fruit',
			'arrosoir' => 'outil',
			'panic' => 'comestible',
			'salicorne' => 'comestible',
			'abricot' => 'fruit',
			'basilic' => 'condiment',
			'brebis' => 'mammifère',
			'guimauve' => 'fleur',
			'lin' => 'comestible',
			'amande' => 'fruit',
			'gentiane' => 'fleur',
			'écluse' => 'outil',
			'carline' => 'plante',
			'câprier' => 'comestible',
			'lentille' => 'légume',
			'aunée' => 'officinale',
			'loutre' => 'mammifère',
			'myrte' => 'comestible',
			'colza' => 'céréale',
			'lupin' => 'fleur',
			'coton' => 'plante',
			'moulin' => 'outil',
			'prune' => 'fruit',
			'millet' => 'céréale',
			'lycoperdon' => 'comestible',
			'escourgeon' => 'céréale',
			'saumon' => 'poisson',
			'tubéreuse' => 'fleur',
			'sucrion' => 'céréale',
			'apocyn' => 'plante',
			'réglisse' => 'officinale',
			'échelle' => 'outil',
			'pastèque' => 'fruit',
			'fenouil' => 'légume',
			'épine vinette' => 'arbre',
			'noix' => 'fruit',
			'truite' => 'poisson',
			'citron' => 'fruit',
			'cardère' => 'plante',
			'nerprun' => 'arbre',
			'tagette' => 'fleur',
			'hotte' => 'outil',
			'églantier' => 'arbre',
			'noisette' => 'fruit',
			'houblon' => 'officinale',
			'sorgho' => 'céréale',
			'écrevisse' => 'crustacé',
			'bigarade' => 'fruit',
			'verge d\'or' => 'plante',
			'maïs' => 'céréale',
			'marron' => 'fruit',
			'panier' => 'outil',
		];

		$keys = array_keys($day_names);
		$values = array_values($day_names);
		return $keys[$this->republican_day_of_year()];
	}

	function republican_day() {
		return (($this->republican_day_of_year() - 1) % 30) + 1;
	}

	function republican_day_of_decade() {
		return (($this->republican_day_of_year() - 1) % 10) + 1;
	}

	function is_complementary_day() {
		return $this->republican_month() == 13;
	}

	function republican_month_name() {
		switch ($this->republican_month()) {
			case 1:  return "vendémiaire";
			case 2:  return "brumaire";
			case 3:  return "frimaire";
			case 4:  return "nivôse";
			case 5:  return "pluviôse";
			case 6:  return "ventôse";
			case 7:  return "germinal";
			case 8:  return "floréal";
			case 9:  return "prairial";
			case 10: return "messidor";
			case 11: return "thermidor";
			case 12: return "fructidor";

				// Jours complémentaires
			default: return "sans-culottide";
		}
	}

	function republican_month() {
		return floor(($this->republican_day_of_year() - 1) / 30) + 1;
	}

	function republican_year_decimal() {
		$gregorian_year = $this->_gregorian_date->format('Y');
		$gregorian_month = $this->_gregorian_date->format('m');
		$gregorian_day = $this->_gregorian_date->format('d');

		$republican_year = $gregorian_year - 1792;

		if ($gregorian_month > 9) {
			// All years start in september, so any month after that means
			// the year is +1793 instead of +1792
			$republican_year += 1;
		} else if ($gregorian_month == 9) {
			// Since years can start either on 22, 23 or 24 september, let's
			// check more precisely on which date we are.
			if ($gregorian_day >= 22 && $this->_gregorian_date >= self::_first_day_of_year($republican_year + 1)) {
				// If this date is at least equal to the first day of
				// year+1, obviously this year is year+1
				$republican_year += 1;
			}
		}

		// There is no year 0
		if ($republican_year <= 0) {
			$republican_year -= 1;
		}

		return $republican_year;
	}

	function republican_year_roman() {
		return self::_to_roman($this->republican_year_decimal());
	}

	function republican_year() {
		return $this->republican_year_decimal();
	}

	public function first_day_of_year() {
		return self::_first_day_of_year($this->republican_year_decimal());
	}

	public function is_year_sextile() {
		return self::_is_year_sextile($this->republican_year_decimal());
	}

	private static function _first_day_of_year($republican_year) {
		$first_day = 0;

		switch ($republican_year) {
			case 4:
			case 8:
				$first_day = 23;
				break;
			case 12:
			case 16:
				$first_day = 24;
				break;
			default:
				$first_day = 24
					- floor(($republican_year - 1) / 100)
					+ floor(($republican_year - 1) / 400)
					+ floor(($republican_year - 209) / 100)
					- floor(($republican_year - 209) / 400);
				break;
		}

		$republican_date = new DateTime();
		$republican_date->setTimestamp(mktime(0, 0, 0, 9, $first_day, $republican_year + 1791));

		return $republican_date;
	}

	private static function _is_year_sextile($republican_year) {
		switch ($republican_year) {
			case 3:
			case 7:
			case 11:
				return true;
			default:
				return $republican_year > 14 && (
						($republican_year % 4 == 0 && ($republican_year + 1792) % 100 != 0)
						|| (($republican_year + 1792) % 400 == 0 && ($republican_year + 1792) % 4000 != 0)
				);

		}
	}

	private static function _to_roman($arabic) {
		$table = [
			'M'  => 1000,
			'CM' =>  900,
			'D'  =>  500,
			'CD' =>  400,
			'C'  =>  100,
			'XC' =>   90,
			'L'  =>   50,
			'XL' =>   40,
			'X'  =>   10,
			'IX' =>    9,
			'V'  =>    5,
			'IV' =>    4,
			'I'  =>    1,
		];

		$roman = '';
		while ($arabic > 0) {
			foreach($table as $rom=>$arb) {
				if($arabic >= $arb) {
					$arabic -= $arb;
					$roman .= $rom;
					break;
				}
			}
		}

		return $roman;
	}
}
