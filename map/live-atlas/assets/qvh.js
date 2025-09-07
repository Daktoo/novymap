
        window.liveAtlasConfig = {
     servers: {

         novydontpro: {
             label: 'Novymap-qvh',
             dynmap: {
               configuration: 'qvhconfig.json',
	  update: 'standalone/MySQL_update.php?world={world}&ts={timestamp}',
  	sendmessage: 'standalone/MySQL_sendmessage.php',
  	login: 'standalone/MySQL_login.php',
  	register: 'standalone/MySQL_register.php',
  	tiles: 'standalone/MySQL_tiles.php?tile=',
 	 markers: 'hack/'
             }
         },
    
              creative: {
             label: 'Creative',
             dynmap: {
               configuration: 'crqvhconfig.json',
  update: 'crstandalone/MySQL_update.php?world={world}&ts={timestamp}',
  sendmessage: 'crstandalone/MySQL_sendmessage.php',
  login: 'crstandalone/MySQL_login.php',
  register: 'crstandalone/MySQL_register.php',
  tiles: 'crstandalone/MySQL_tiles.php?tile=',
  markers: 'crstandalone/MySQL_markers.php?marker='
                             }
         },
     },

            // These messages are used throughout LiveAtlas and can be translated here
            // If a message you want to translate isn't here, it is likely controlled by dynmap itself
            // see https://github.com/webbukkit/dynmap/wiki/Configuration.txt
            messages: {
            	chatNoMessages: 'No chat messages yet...',
                chatTitle: 'Chat',
                chatLogin: 'Please login to send chat messages',
                chatSend: 'Send',
                chatPlaceholder: 'Type your chat message here...',
                chatErrorUnknown: 'Unexpected error while sending chat message',
                chatErrorDisabled: 'Chat is not enabled',
            	serversHeading: 'Maps',
                markersHeading: 'Markers',
                markersSearchPlaceholder: 'Search markers...',
                markersSkeleton: 'No markers exist for the current world',
                markersSetSkeleton: 'This marker set is empty',
                markersSearchSkeleton: 'No matching markers found',
                markersUnnamed: '(Unnamed marker)',
                worldsSkeleton: 'No maps have been configured',
                playersSkeleton: 'No players are currently online',
                playersTitle: 'Click to center on player\nDouble-click to follow player',
                playersTitleHidden: 'This player is currently hidden from the map\nDouble-click to follow player when they become visible',
                playersTitleOtherWorld: 'This player is in another world.\nClick to center on player\nDouble-click to follow player',
                playersSearchPlaceholder: 'Search players...',
                playersSearchSkeleton: 'No matching players found',
                followingHeading: 'Following',
                followingUnfollow: 'Unfollow',
                followingTitleUnfollow: 'Stop following this player',
                followingHidden: 'Currently hidden',
                linkTitle: 'Copy link to current location',
                loadingTitle: 'Loading...',
                locationRegion: 'Region',
                locationChunk: 'Chunk',
                contextMenuCopyLink: 'Copy link to here',
                contextMenuCenterHere: 'Center here',
                toggleTitle: 'Click to toggle this section',
                mapTitle: 'Map - Use the arrow keys to pan the map',
                layersTitle: 'Layers',
                copyToClipboardSuccess: 'Copied to clipboard',
                copyToClipboardError: 'Unable to copy to clipboard',

                loginTitle: 'Login/Register',
                loginHeading: 'Existing User',
                loginUsernameLabel: 'Username',
                loginPasswordLabel: 'Password',
                loginSubmit: 'Login',
                loginErrorUnknown: 'Unexpected error while logging in',
                loginErrorDisabled: 'Logging in is disabled on this server',
                loginErrorIncorrect: 'Incorrect username or password',
                loginSuccess: 'Logged in successfully',

                registerHeading: 'New User',
                registerDescription: `Enter your username and password, along with your registration code.

                        You can get a registration code by running /dynmap webregister in-game.`,
                registerConfirmPasswordLabel: 'Confirm Password',
                registerCodeLabel: 'Registration Code',
                registerSubmit: 'Register',
                registerErrorUnknown: 'Unexpected error during registration',
                registerErrorDisabled: 'Registration is disabled on this server',
                registerErrorVerifyFailed: 'The entered passwords do not match',
                registerErrorIncorrect: 'Registration failed, please check the entered details are correct',

                logoutTitle: 'Logout',
                logoutErrorUnknown: 'Unexpected error while logging out',
                logoutSuccess: 'Logged out successfully',

                closeTitle: 'Close',
                showMore: 'Show more'
            },

            ui: {
            	// If true, player markers will always be displayed in front of other marker types
            	playersAboveMarkers: true,

                // Whether to enable the player list search box
                playersSearch: true,

                // Use more compact pre-2.0 player marker style
                compactPlayerMarkers: false,

                // Disable the map right click menu
                disableContextMenu: false,

                // Disable the markers button and list
                disableMarkerUI: false,

                // Custom URL to redirect to when logging in is required
                // This URL will need to handle the login process and redirect users back to LiveAtlas
                customLoginUrl: null
            },

            // Config version. Do not modify.
            version: 1
        };
    



ah=1;
function checkFlag() {
    if(!window.liveAtlasLoaded) {
       window.setTimeout(checkFlag, 100);
    } else {

var posbox = document.getElementsByClassName("leaflet-top leaflet-left")[0];
    var logobox = document.createElement("div");
	logobox.setAttribute("onClick", "toggleTheme()");
    logobox.id = "qvhhackbox"+ah;
    logobox.className = "leaflet-control-logo leaflet-control";
    logobox.innerHTML = `<svg class="lighticon svg-icon" viewBox="0 -960 960 960" fill="#e3e3e3"><path d="M480-360q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0 80q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Zm326-268Z"></path></svg>
<svg class="darkicon svg-icon" viewBox="0 -960 960 960" fill="#e3e3e3"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Zm0-80q88 0 158-48.5T740-375q-20 5-40 8t-40 3q-123 0-209.5-86.5T364-660q0-20 3-40t8-40q-78 32-126.5 102T200-480q0 116 82 198t198 82Zm-10-270Z"></path></svg>`;
	posbox.appendChild(logobox);
ah++;

}
}
checkFlag();

