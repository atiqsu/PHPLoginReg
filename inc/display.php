<?php

/**
 * Description of the display object
 *
 * @author alex
 */
class display {
    public $title = 'Ingen overskrift';
    public $description = '';

    /**
     * Some static variables to define state of script
     */
    
    public static $STATUS_IGNORE = 0;
    public static $STATUS_GOOD = 1;
    public static $STATUS_ERROR = 2;
    public static $STATUS_WARNING = 3;
    public static $STATUS_INFO = 4;
    
    /**
     *
     */
    public $status = 0;
    
    /**
     *
     * @var array BreadCrumbs that show you where you are
     */
    protected $breadCrumbs = array();

    /**
     *
     * @var boolean Show breadCrumbs or not
     */
    protected $show_breadCrumbs = true;


    /**
     * Returns a string which makes the link bold if it's where the user is.
     * Use this with echo in a link, inside the tag
     * @param string $side Page the link is pointing to.
     * @return string Text that makes the link bold if it's where the user is, empty string if not.
     */
    public function nav ($side) {
        $denne_sida = $_SERVER['REQUEST_URI'];
        $denne_sida = explode('/', $denne_sida);
        $denne_sida = $denne_sida[(count($denne_sida) - 1)];

        if ($denne_sida == $side) {
            return 'class="nav_current"';

        }
        return '';
    }


    /**
     * Redirecter brukeren dersom rettigheten ikke kan f�s tak i.
     *
     * Et eksempel p� bruk:
     * <code>
     * // Vi krever at man kan legge til en compo
     * $VIS->krevRettighet('leggTilCompo');
     * </code>
     * 
     * @global Innstillinger $innstillinger Innstillingene, brukes til � generere URL.
     * @param string $rettighet Rettigheten som det er krevd at brukeren har. Sjekk tilganger.inc.php for rettighetene.
     * @return boolean true dersom brukeren har rettigheten, vil redirecte og d� ellers
     * @deprecated since version 0.1
     */
    public function krevRettighet ($rettighet = false) {
        global $innstillinger;
        try {
            if (!Bruker::innloggetBruker() instanceof Bruker) {
                throw new IkkeInnlogget();
            }

            if (($rettighet != false) && (!Bruker::kanGjore($rettighet))) {
                throw new HarIkkeTilgang();
            }
            return true;
        }

        catch (IkkeInnlogget $e) {
            $msg = MSG_INNLOGGING_PAKREVD;
        }
        catch (HarIkkeTilgang $e) {
            $msg = MSG_IKKE_TILGANG;
        }

        header('Location: '.$innstillinger->url . '/logginn.php?msg='.$msg);
        exit('Redirecter...');
    }

    public function createBreadCrumbs () {
        // Is breadCrumbs aktivated?
        if (!$this->show_breadCrumbs) {
            return false;
        }
        // It is, lets put it inside a div.
    ?>
        <div id="bread_crumbs">
            <?php
            // Go through every breadCrumbs inside the array
            $number_bread_crumbs = (count($this->breadCrumbs) - 1);
            foreach ($this->breadCrumbs as $bread_crumb_num => $bread_crumb) {
                // Is this the last one? If it is, the text should be bold, not a link.
                if ($number_bread_crumbs == $bread_crumb_num) {
                    ?>
            <b><?php echo $bread_crumb['name']; ?></b>
                            <?php

                        } else {
                        ?>
            <a href="<?php echo $bread_crumb['url']; ?>" title="<?php echo $bread_crumb['title']; ?>">
                <?php echo $bread_crumb['name']; ?></a> <img src="img/arrow.png" alt="og videre..."/>
        <?php
                        }
                    }
                    ?>
        </div>
<?php
    }

    public function activateBC () {
        $old = $this->show_breadCrumbs;
        $this->show_breadCrumbs = true;
        return $old;
    }

    public function deactivateBC () {
        $old = $this->show_breadCrumbs;
        $this->show_breadCrumbs = false;
        return $old;
    }

    public function addBCpath ($url, $name, $title = false, $number = false) {
        $new_path = array(
            'url' => $url,
            'name' => $name,
            'title' => $title);
        if ($number === false) {
            $this->breadCrumbs[] = $new_path;
        } else {
            $this->breadCrumbs[$number] = $new_path;
        }

        return $new_path;
    }

}

// Lag visnings-objektet
$VIS = new display();

// Fyll inn ett element i br�dstien
$VIS->addBCpath('index.php', 'MainPage', 'Start Page where you can blerg *Display.php*');
$VIS->deactivateBC();
