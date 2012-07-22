<?php
/**
 * @package openpsa.template
 * @author CONTENT CONTROL http://www.contentcontrol-berlin.de/
 * @copyright CONTENT CONTROL http://www.contentcontrol-berlin.de/
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * Simplistic DB bootstrapper that creates a root topic and config file
 *
 * @package openpsa.template
 */
class bootstrap
{
    private $_basedir;

    public function __construct($basedir)
    {
        $this->_basedir = $basedir;
    }

    public function run()
    {
        $topic = new midgard_topic;
        if (!$topic->create())
        {
            throw new Exception('Failed to create root topic');
        }
        $GLOBALS['midcom_config_local']['midcom_root_topic_guid'] = $topic->guid;
        $config = "<?php\n";
        $config .= "\$GLOBALS['midcom_config_local']['midcom_root_topic_guid'] = '$topic->guid';\n";
        $config .= '?>';

        if (is_writable($this->_basedir))
        {
            file_put_contents($this->_basedir . 'config.inc.php', $config);
        }
        else
        {
            echo '<p>Save this to <code>' . $this->_basedir . "config.inc.php</code:</p>\n";
            echo '<pre>';
            echo htmlentities($config);
            echo '</pre>';
            exit;
        }
    }
}
?>