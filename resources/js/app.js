import './bootstrap';
import { confirmDelete } from './confirmDelete';
import { redirectToRoute } from './redirect';

import Alpine from 'alpinejs';

window.confirmDelete = confirmDelete;
window.redirectToRoute = redirectToRoute;


import Dropzone from "dropzone";

window.Alpine = Alpine;

Alpine.start();


