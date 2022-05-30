import React from 'react'

const fetchAids = (geographicalAreaId, aidTypeId, projectStatusId, subTopicId, path = '/api/aides?') => {

  let geographicalAreaQueryString = '';
  if (geographicalAreaId !== '') {
    geographicalAreaQueryString = '&zonesGeographiques=' + geographicalAreaId;
  }

  let aidTypeQueryString = '';
  if (aidTypeId !== '') {
    aidTypeQueryString = '&typesAide=' + aidTypeId;
  }

  let projectStatusQueryString = '';
  if (projectStatusId !== '') {
    projectStatusQueryString = '&etatsAvancementProjet=' + projectStatusId;
  }

  let subTopicQueryString = '';
  if (subTopicId !== '') {
    subTopicQueryString = '&sousThematiques=' + subTopicId;
  }

  return fetch(`${path}${geographicalAreaQueryString}${aidTypeQueryString}${projectStatusQueryString}${subTopicQueryString}`)
    .then(response => response.json())
};

const fetchAidTypes = () => {
  return fetch('/api/type_aides.json')
    .then(response => response.json())
};

const fetchProjectStatus = () => {
  return fetch('/api/etat_avancement_projets.json')
    .then(response => response.json())
};

const fetchTopics = () => {
  return fetch('/api/thematiques.json')
      .then(response => response.json())
};

const fetchRecurrences = () => {
  return fetch('/api/recurrence_aides.json')
    .then(response => response.json())
};

const fetchExpenseTypes = () => {
  return fetch('/api/type_depenses.json')
    .then(response => response.json())
};

const fetchGeographicalAreas = () => {
  return fetch('/api/zone_geographiques.json')
    .then(response => response.json())
};

export {fetchAids, fetchGeographicalAreas, fetchAidTypes, fetchProjectStatus, fetchTopics}
