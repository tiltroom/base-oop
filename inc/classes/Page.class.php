<?php

class Page
{
    public function __construct()
    {
        // start db en Sessie
        $this->session = new Session;
    }

    public function Showpage($perm, $page, $rank = Null)
    {
        $file = getenv('DOCUMENT_ROOT') . '/pages/';

        if ($perm === 'logout') {
            session_destroy();
            return header('Refresh:0; url=../?logout=success');
        }

        if($this->CheckRank($perm,$rank)) {
            $file .= $perm . '/';
        }

        if ($page === null) {
            $page = 'home';
        }

        $file .= $page . '.php';


        if (file_exists($file)) {
            //here we show the header , feel free to adjust to fit your own template (pages/template/)
            $this->Template('header');
            //my sidebar , depending on template you need it or not ( pages/template/)
            $this->Template('sidebar');
            require_once $file;
            //Here is the footer -> read the footer.php file in "/pages/template/"
            $this->Template('footer');
        } else {
            header('location: /');
        }
    }

    protected function Template($info)
    {
        require_once (getenv('DOCUMENT_ROOT') . "/template/boot/$info.php");
    }

    private function CheckRank($perm, $rank) {
        return $rank !== null && $perm === $rank;
    }
}

/* CopyRight PowerChaos 2016 */