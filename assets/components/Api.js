import React from 'react'

const fetchEnvrtonmentalTopics = () => {
    return fetch('/api/environmental-topics')
      .then(response => response.json())
};

export {fetchEnvrtonmentalTopics}