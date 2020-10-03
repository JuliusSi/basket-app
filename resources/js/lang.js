import Language from 'lang.js';
import translations from '../../public/messages';
const lang = new Language({
    messages: translations,
    locale: 'lt',
    fallback: 'en'
});

export default lang;
