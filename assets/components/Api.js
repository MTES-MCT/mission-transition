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
    let environmentalCategoryQueryString = '&category=' + environmentalCategory.value;

    let environmentalTopicQueryString = '';
    if (environmentalTopicSelected !== null && environmentalTopicSelected.value !== 0) {
        environmentalTopicQueryString = '&topic=' + environmentalTopicSelected.value;
    }

    let aidTypesQueryString = '';
    if (aidTypes !== null) {
        aidTypes.forEach(option => {
            aidTypesQueryString += '&aidTypes[]=' + option.value
        })
    }

    let regionsQueryString = (region !== null && region.value !== undefined) ? '&region=' + region.value : '';
    let searchQueryString = (region !== '') ? '&search=' + searchValue : '';

    let url = `/api/aids?${environmentalCategoryQueryString}${aidTypesQueryString}${regionsQueryString}${environmentalTopicQueryString}${searchQueryString}`;
    console.log(url);

    return fetch(url)
      .then(response => response.json())
};

export {fetchEnvironmentalTopicCategories, fetchAidTypes, fetchRegions, fetchAids}
