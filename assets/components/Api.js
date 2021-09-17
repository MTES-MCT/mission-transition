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

const fetchAids = (environmentalTopics, aidTypes, regions) => {
    let environmentalTopicsQueryString = '&topics[]=' + environmentalTopics.value;

    let aidTypesQueryString = '';
    if (aidTypes !== null) {
        aidTypes.forEach(option => {
            aidTypesQueryString += '&aidTypes[]=' + option.value
        })
    }

    let regionsQueryString = (regions !== null && regions.value !== undefined) ? '&regions[]=' + regions.value : '';

    let url = `/api/aids?${environmentalTopicsQueryString}${aidTypesQueryString}${regionsQueryString}`;
    console.log(url);

    return fetch(url)
      .then(response => response.json())
};

export {fetchEnvironmentalTopicCategories, fetchAidTypes, fetchRegions, fetchAids}
