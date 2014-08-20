<?php
require './inc/startup.php';
/* @var $VIS display */
/* @var $settings settings */

// Let's run some test to check if everything is running like it should

$test = [];
// Can we write to the data folder?
if (is_writable('data')) {
    $test['data_folder'] = true;
} else {
    $test['data_folder'] = false;
}

// Does the settings file exist?
if (file_exists($settings->settingsFile())) {
    $test['settings_file'] = true;
} else {
    $test['settings_file'] = false;
}

// Can we write to the settings file?
if (file_exists($settings->settingsFile()) && is_writable($settings->settingsFile())) {
    $test['write_settings'] = true;
} else {
    $test['write_settings'] = false;
}

$VIS->pageTitle = 'System status';

include HTML_START;

?>
<h3>
    System-status
</h3>

<h4>Is the data folder writeable: <?php echo $test['data_folder'] ? "<span class='test_yes'>Yes!</span>" :
"<span class='test_no'>No!</span>";?> </h4>

<p>The Data folder is used to save settings changed from here, and unlock files.</p>
<?php if (!$test['data_folder']) { ?>
<p>The problem can be fixed with chmod or chown.</p>
<?php } ?>
<h4>Does the settings file exist: <?php
echo $test['settings_file'] ? "<span class='test_yes'>Yes!</span>"
        : "<span class='test_warning'>No!</span>"; ?></h4>
<?php if (!$test['settings_file']) { ?>
<p>This is not a critical problem, sinse we will use the Standard settings </p>
<p>It would however be wise to check your settings.</p>
<?php } else { ?>
<h4>Is the settings file writeable: <?php
echo $test['write_settings'] ? "<span class='test_yes'>Yes!</span>"
        : "<span class='test_no'>No!</span>";
?></h4>

<?php if (!$test['write_settings']) { ?>
<p>You cannot change settings from the page. The problem can be fixed with chmod or chown.</p>
<?php } }