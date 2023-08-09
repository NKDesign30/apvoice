<?php

/* Main Headless SSO Function which is called on addition of Menu and Submenu pages.
	Function to display the correct page content based on the active tab. */
function hsso()
{
   ?>

    <div>
        <div>
            <table style="width:100%;">
                <tr>
                    <h2 class="nav-tab-wrapper">
                        <a class="nav-tab" href="admin.php?page=headless_sso">Headless SSO
                        </a>
                    </h2>

                    <td style="vertical-align:top;width:65%;">
                        <?php

                        hsso_general_settings();

                        ?>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <?php


}
/* Function to display general settings. Sets the default access role as editor and author for accessing the meta box while editing/creating */		
function hsso_general_settings() {
    $endpoint = get_option('hsso_endpoint');
    $site_url = get_site_url().'?option=headless_sso';
	echo '
		<div style="display:block;margin-top:1px;background-color:rgba(255, 255, 255, 255);padding-left:10px;padding-right:15px;border:solid 1px rgba(255, 255, 255, 255);border: 1px solid #CCCCCC";>
		    <h3>Plugin endpoint to fetch the JWT token</h3>
		    <hr>
		    <p style="background: #dbdbdb;padding: 2%;font-size:large"><i>'.$site_url.'</i></p>
		    <p>Copy the above endpoint and configure it in your Frontend application, on SSO 
		    redirect to the above endpoint and the plugin will redirect the user to Wordpress Login Page. The user can then enter the credentials and the JWT response will be posted to the configured endpoint.</p>
			<h3>Configure the Front End Endpoint<h3>
			<hr>
			<form method="post" action="">
        		<input type="hidden" name="option" value="hsso_general_settings" />'.
                wp_nonce_field('hsso_general_settings').'
        		
				<div style="padding-left:16px">		
					<h3>Enter the Endpoint you want to receive the JWT token on</h3>
					<p>
						Enter the endpoint where JWT token is sent:&nbsp;&nbsp;
						<input  type="url" style="width:auto;min-width:280px;max-width:400px" 
						name="hsso_endpoint" placeholder="Enter the Endpoint to post the JWT on" 
						value="' . $endpoint . '" >
					</p> 
					
					<p>
					JWT response will include Expiration time, JWT token, Token type, and Time generated on.
</p>
					<br>
					<input type="submit" class="button button-primary button-larges" value="Save Configuration">
					<br><br><br>
				</div>			
			</form>
			
			
		</div>
	';
}


		
