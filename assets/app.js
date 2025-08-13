/*import './bootstrap.js';*/
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import './styles/style.css';



import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
import 'uikit/dist/css/uikit.min.css';

// Active le plugin d'icônes
UIkit.use(Icons);




/* Exemple : init custom
UIkit.notification({message: 'UIKit est chargé !'});*/



console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
