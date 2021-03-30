const fetchCompanyBySiren = (siren) => {
    return fetch(`https://entreprise.data.gouv.fr/api/sirene/v3/unites_legales/${siren}?per_page=20`)
        .then((response) => response.json())
        .then((data) => data);
};

const fetchCompanyBySiret = (siret) => {
    return fetch(`https://entreprise.data.gouv.fr/api/sirene/v3/etablissements/${siret}?per_page=20`)
        .then((response) => response.json())
        .then((data) => data);
};

const fetchCompaniesByText = (text) => {
    return fetch(`https://entreprise.data.gouv.fr/api/sirene/v1/full_text/${text}?per_page=20`)
        .then((response) => response.json())
        .then((data) => data);
};

export { fetchCompanyBySiren, fetchCompanyBySiret, fetchCompaniesByText };
