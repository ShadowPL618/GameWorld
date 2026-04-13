<?php
/**
 * GameWorld - Download Page
 * Simple download page for Astroidinator executable
 * 
 * Users can download the Astroidinator.exe application directly
 * No verification codes or authentication required
 */

// Set page title for the download page
$page_title = 'GameWorld - Download Astroidinator';

// Full server path to the executable file
$exeFile = realpath(__DIR__ . '/../Astroidinator.exe/obj/Debug/Astroidinator_SDE2025_Jkra.exe');

// Serve the executable directly when download is requested
if (isset($_GET['download'])) {
    if ($exeFile && file_exists($exeFile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="Astroidinator_SDE2025_Jkra.exe"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($exeFile));
        readfile($exeFile);
        exit;
    }

    header('HTTP/1.1 404 Not Found');
    echo 'Download file not found. Please contact support.';
    exit;
}

// Include the site header template
include '../includes/header.php';
?>

<section class="download-page">
    <div class="container">
        
        <!-- Page heading -->
        <h1 class="page-title">Download Astroidinator</h1>
        
        <!-- Game description -->
        <div class="download-intro">
            <div class="game-info">
                <h2>🚀 Astroidinator</h2>
                <p>Experience the ultimate space shooter game! Navigate through asteroid fields, 
                   defeat alien enemies, and save the galaxy.</p>
                <p><strong>System Requirements:</strong> Windows 10 or later, 2GB RAM, 500MB disk space</p>
            </div>
        </div>
        
        <!-- Download section with direct download button -->
        <div class="download-success">
            <h2>Ready to Play?</h2>
            <p>Click the button below to download and install Astroidinator on your computer.</p>
            
            <!-- Download button - uses the PHP download handler to serve the .exe file -->
            <div class="download-button-container">
                <a href="download.php?download=1" 
                   class="btn-download">
                    ⬇️ Download Astroidinator
                </a>
            </div>
            
            <!-- Installation instructions for users -->
            <div class="download-info">
                <h3>Installation Instructions:</h3>
                <ol>
                    <li>Click the download button above</li>
                    <li>Run the installer (.exe file)</li>
                    <li>Follow the on-screen installation steps</li>
                    <li>Launch the game and enjoy!</li>
                </ol>
                
                <h3>Safety & Security:</h3>
                <p>The Astroidinator.exe file is safe and secure. Your browser may show a warning 
                   about downloading executable files - this is normal. Proceed with the download 
                   to continue installation.</p>
            </div>
        </div>
        
    </div>
</section>

<?php
// Include the site footer template
include '../includes/footer.php';
?>
