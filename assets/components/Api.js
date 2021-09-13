import React from 'react'

const fetchEnvrtonmentalTopics = () => {
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

const fetchAids = () => {
    return fetch('/api/aids')
      .then(response => response.json())
};

export {fetchEnvrtonmentalTopics, fetchAidTypes, fetchRegions}
