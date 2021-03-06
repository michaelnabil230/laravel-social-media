import './bootstrap';
import hljs from 'highlight.js';
import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.css';
require('./editor');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Syntax highlight code blocks.
window.highlightCode = (element) => {
    element.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightElement(block);
    });
};

// Create a select element.
window.choices = (element) => {
    return new Choices(element, { removeItemButton: true });
};

window.Vue = require('vue').default;
Vue.component('chat-app', require('./components/ChatApp.vue').default);
Vue.component('chat-messages', require('./components/ChatMessages.vue').default);
Vue.component('chat-form', require('./components/ChatForm.vue').default);
