<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license   // TODO Licence
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

/**
 * Tracker class.
 *
 * @package Easy_Related_Posts
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROTracker {

    /**
     * DB actions object
     * @var erpPRODBActions
     */
    private $db;
    private $wpSession;
    private $disableTracking;

    /**
     * Constructor
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    function __construct(erpPRODBActions $dbActions, $wpSession, $disableTracking) {
        $this->db = $dbActions;
        $this->wpSession = $wpSession;
        $this->disableTracking = $disableTracking;
    }

    /**
     * Tracking logic
     *
     * @since 1.0.0
     */
    public function tracker() {
        if (is_admin() || $this->is_bot()) {
            return;
        }

        $refererName = $this->getRefererName(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' );
        $request = $this->getRequestString();
        $id = url_to_postid($request);

        if ($id > 0 && !$this->disableTracking) {
            $this->setAsVisited($id);
        }

        if ($refererName === 'local') {
            $parsedReq = $this->parseSearchQuery($request);
            if (isset($parsedReq['erp_from']) && $id > 0) {
                $this->db->addClick($parsedReq['erp_from'], $id);
            }
        }
    }

    /**
     * Sets curent post as visited
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    private function setAsVisited($pid) {
        if (isset($this->wpSession ['visited'])) {
            $push = unserialize($this->wpSession ['visited']);
            if (!in_array($pid, $push)) {
                array_push($push, $pid);
                $this->wpSession ['visited'] = serialize($push);
            }
        } else {
            $this->wpSession ['visited'] = serialize(array(
                $pid
                    ));
        }
    }

    /**
     * Get the referer string from server
     *
     * @return string $_SERVER['HTTP_REFERER'] if is set, empty string otherwise
     * @since 1.0.0
     */
    private function getRequestString() {
        return isset($_SERVER['REQUEST_URI']) ? urldecode($_SERVER['REQUEST_URI']) : '';
    }

    /**
     * Get the referer
     *
     * @param string $refString
     *        	The referer string ( $_SERVER [ 'HTTP_REFERER' ] like )
     * @return string or boolean. The referer if found (local for local navigation) or false if ref not found
     * @since 1.0.0
     */
    private function getRefererName($refString) {
        if (is_int(strpos($refString, site_url()))) {
            return 'local';
        }

        return 'unknown';
    }

    /**
     * Parses a string and returns the PHP_URL_QUERY vars as assosiative array
     *
     * @param string $request
     * @return array An assosiative array containing the search vars
     * @since 1.0.0
     */
    private function parseSearchQuery($request) {
        parse_str(parse_url($request, PHP_URL_QUERY), $out);
        if (!isset($out['p'])) {
            $out['p'] = null;
        }
        return $out;
    }

    /**
     * Checks if user agent is a bot
     * @return boolean True if agent is a bot
     * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    private function is_bot() {
        $spiders = array(
            "abot",
            "dbot",
            "ebot",
            "hbot",
            "kbot",
            "lbot",
            "mbot",
            "nbot",
            "obot",
            "pbot",
            "rbot",
            "sbot",
            "tbot",
            "vbot",
            "ybot",
            "zbot",
            "bot.",
            "bot/",
            "_bot",
            ".bot",
            "/bot",
            "-bot",
            ":bot",
            "(bot",
            "crawl",
            "slurp",
            "spider",
            "seek",
            "accoona",
            "acoon",
            "adressendeutschland",
            "ah-ha.com",
            "ahoy",
            "altavista",
            "ananzi",
            "anthill",
            "appie",
            "arachnophilia",
            "arale",
            "araneo",
            "aranha",
            "architext",
            "aretha",
            "arks",
            "asterias",
            "atlocal",
            "atn",
            "atomz",
            "augurfind",
            "backrub",
            "bannana_bot",
            "baypup",
            "bdfetch",
            "big brother",
            "biglotron",
            "bjaaland",
            "blackwidow",
            "blaiz",
            "blog",
            "blo.",
            "bloodhound",
            "boitho",
            "booch",
            "bradley",
            "butterfly",
            "calif",
            "cassandra",
            "ccubee",
            "cfetch",
            "charlotte",
            "churl",
            "cienciaficcion",
            "cmc",
            "collective",
            "comagent",
            "combine",
            "computingsite",
            "csci",
            "curl",
            "cusco",
            "daumoa",
            "deepindex",
            "delorie",
            "depspid",
            "deweb",
            "die blinde kuh",
            "digger",
            "ditto",
            "dmoz",
            "docomo",
            "download express",
            "dtaagent",
            "dwcp",
            "ebiness",
            "ebingbong",
            "e-collector",
            "ejupiter",
            "emacs-w3 search engine",
            "esther",
            "evliya celebi",
            "ezresult",
            "falcon",
            "felix ide",
            "ferret",
            "fetchrover",
            "fido",
            "findlinks",
            "fireball",
            "fish search",
            "fouineur",
            "funnelweb",
            "gazz",
            "gcreep",
            "genieknows",
            "getterroboplus",
            "geturl",
            "glx",
            "goforit",
            "golem",
            "grabber",
            "grapnel",
            "gralon",
            "griffon",
            "gromit",
            "grub",
            "gulliver",
            "hamahakki",
            "harvest",
            "havindex",
            "helix",
            "heritrix",
            "hku www octopus",
            "homerweb",
            "htdig",
            "html index",
            "html_analyzer",
            "htmlgobble",
            "hubater",
            "hyper-decontextualizer",
            "ia_archiver",
            "ibm_planetwide",
            "ichiro",
            "iconsurf",
            "iltrovatore",
            "image.kapsi.net",
            "imagelock",
            "incywincy",
            "indexer",
            "infobee",
            "informant",
            "ingrid",
            "inktomisearch.com",
            "inspector web",
            "intelliagent",
            "internet shinchakubin",
            "ip3000",
            "iron33",
            "israeli-search",
            "ivia",
            "jack",
            "jakarta",
            "javabee",
            "jetbot",
            "jumpstation",
            "katipo",
            "kdd-explorer",
            "kilroy",
            "knowledge",
            "kototoi",
            "kretrieve",
            "labelgrabber",
            "lachesis",
            "larbin",
            "legs",
            "libwww",
            "linkalarm",
            "link validator",
            "linkscan",
            "lockon",
            "lwp",
            "lycos",
            "magpie",
            "mantraagent",
            "mapoftheinternet",
            "marvin/",
            "mattie",
            "mediafox",
            "mediapartners",
            "mercator",
            "merzscope",
            "microsoft url control",
            "minirank",
            "miva",
            "mj12",
            "mnogosearch",
            "moget",
            "monster",
            "moose",
            "motor",
            "multitext",
            "muncher",
            "muscatferret",
            "mwd.search",
            "myweb",
            "najdi",
            "nameprotect",
            "nationaldirectory",
            "nazilla",
            "ncsa beta",
            "nec-meshexplorer",
            "nederland.zoek",
            "netcarta webmap engine",
            "netmechanic",
            "netresearchserver",
            "netscoop",
            "newscan-online",
            "nhse",
            "nokia6682/",
            "nomad",
            "noyona",
            "nutch",
            "nzexplorer",
            "objectssearch",
            "occam",
            "omni",
            "open text",
            "openfind",
            "openintelligencedata",
            "orb search",
            "osis-project",
            "pack rat",
            "pageboy",
            "pagebull",
            "page_verifier",
            "panscient",
            "parasite",
            "partnersite",
            "patric",
            "pear.",
            "pegasus",
            "peregrinator",
            "pgp key agent",
            "phantom",
            "phpdig",
            "picosearch",
            "piltdownman",
            "pimptrain",
            "pinpoint",
            "pioneer",
            "piranha",
            "plumtreewebaccessor",
            "pogodak",
            "poirot",
            "pompos",
            "poppelsdorf",
            "poppi",
            "popular iconoclast",
            "psycheclone",
            "publisher",
            "python",
            "rambler",
            "raven search",
            "roach",
            "road runner",
            "roadhouse",
            "robbie",
            "robofox",
            "robozilla",
            "rules",
            "salty",
            "sbider",
            "scooter",
            "scoutjet",
            "scrubby",
            "search.",
            "searchprocess",
            "semanticdiscovery",
            "senrigan",
            "sg-scout",
            "shai'hulud",
            "shark",
            "shopwiki",
            "sidewinder",
            "sift",
            "silk",
            "simmany",
            "site searcher",
            "site valet",
            "sitetech-rover",
            "skymob.com",
            "sleek",
            "smartwit",
            "sna-",
            "snappy",
            "snooper",
            "sohu",
            "speedfind",
            "sphere",
            "sphider",
            "spinner",
            "spyder",
            "steeler/",
            "suke",
            "suntek",
            "supersnooper",
            "surfnomore",
            "sven",
            "sygol",
            "szukacz",
            "tach black widow",
            "tarantula",
            "templeton",
            "/teoma",
            "t-h-u-n-d-e-r-s-t-o-n-e",
            "theophrastus",
            "titan",
            "titin",
            "tkwww",
            "toutatis",
            "t-rex",
            "tutorgig",
            "twiceler",
            "twisted",
            "ucsd",
            "udmsearch",
            "url check",
            "updated",
            "vagabondo",
            "valkyrie",
            "verticrawl",
            "victoria",
            "vision-search",
            "volcano",
            "voyager/",
            "voyager-hc",
            "w3c_validator",
            "w3m2",
            "w3mir",
            "walker",
            "wallpaper",
            "wanderer",
            "wauuu",
            "wavefire",
            "web core",
            "web hopper",
            "web wombat",
            "webbandit",
            "webcatcher",
            "webcopy",
            "webfoot",
            "weblayers",
            "weblinker",
            "weblog monitor",
            "webmirror",
            "webmonkey",
            "webquest",
            "webreaper",
            "websitepulse",
            "websnarf",
            "webstolperer",
            "webvac",
            "webwalk",
            "webwatch",
            "webwombat",
            "webzinger",
            "wget",
            "whizbang",
            "whowhere",
            "wild ferret",
            "worldlight",
            "wwwc",
            "wwwster",
            "xenu",
            "xget",
            "xift",
            "xirq",
            "yandex",
            "yanga",
            "yeti",
            "yodao",
            "zao/",
            "zippp",
            "zyborg",
            "...."
        );

        foreach ($spiders as $spider) {
            // If the spider text is found in the current user agent, then return true
            if (stripos($_SERVER ['HTTP_USER_AGENT'], $spider) !== false)
                return true;
        }
        // If it gets this far then no bot was found!
        return false;
    }

}
