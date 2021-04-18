import bn from "./../../lang/bn.json";

const languages = {
    bn: bn
};

export const SelectedLanguage = () => {
    if (localStorage.getItem("languageCode")) {
        try {
            return localStorage.getItem("languageCode");
        } catch (e) {
            return "bn";
        }
    }
    return "bn";
};

export const ChangeLanguage = languageCode => {
    localStorage.setItem("languageCode", languageCode);
};

export const LanguageTranslation = {
    getLanguage: language => {
        return languages[language];
    }
};

export { LanguageTranslation as default };
