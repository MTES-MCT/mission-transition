import React from 'react'

const fetchEnvironmentalTopicCategories = () => {
    return fetch('/api/environmental-topics')
      .then(response => response.json())
};

const fetchAidTypes = () => {
    return fetch('/api/aid-types')
        .then(response => response.json())
};

const fetchRegions = () => {
    return fetch('/api/regions')
        .then(response => response.json())
};

const fetchAids = (environmentalCategory, aidTypes, region, environmentalTopicSelected, searchValue) => {
    let environmentalCategoryQueryString = '';
    if (environmentalCategory !== "") {
        environmentalCategoryQueryString = '&category=' + environmentalCategory;
    }

    let environmentalTopicQueryString = '';
    if (environmentalTopicSelected !== null && environmentalTopicSelected !== 0) {
        environmentalTopicQueryString = '&topic=' + environmentalTopicSelected;
    }

    let aidTypesQueryString = '';
    if (aidTypes !== null) {
        aidTypes.forEach(option => {
            aidTypesQueryString += '&aidTypes[]=' + option.value
        })
    }

    let regionsQueryString = (region !== "" && region !== undefined) ? '&region=' + region : '';
    let searchQueryString = (searchValue !== '') ? '&search=' + searchValue : '';

    let url = `/api/aids?${environmentalCategoryQueryString}${aidTypesQueryString}${regionsQueryString}${environmentalTopicQueryString}${searchQueryString}`;
    return fetch(url)
      .then(response => response.json())
};

export {fetchEnvironmentalTopicCategories, fetchAidTypes, fetchRegions, fetchAids}
