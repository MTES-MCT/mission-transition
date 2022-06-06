import React, { useState, useEffect } from "react";
import {fetchAids, fetchAidTypes, fetchGeographicalAreas, fetchTopics} from "./Api";


const SearchEngineExtension = () => {

    const [geographicalAreas, setGeographicalAreas] = useState([]);
    const [topics, setTopics] = useState([]);
    const [aidTypes, setAidTypes] = useState([]);
    const [selectedGeographicalAreaId, setSelectedGeographicalAreaId] = useState('');
    const [selectedAidTypeId, setSelectedAidTypeId] = useState('');
    const [selectedTopicId, setSelectedTopicId] = useState('');
    const [selectedSubTopicId, setSelectedSubTopicId] = useState('');
    const [selectedTopicPipeSubTopicIds, setSelectedTopicPipeSubTopicIds] = useState('');
    const [totalItems, setTotalItems] = useState(0);

    const getMappedOptions = (items, valueField, valueNameField) => {
        return items.map((item, index) => <option
            key={index}
            value={item[valueField]}>{item[valueNameField]}
        </option>)
    }

    const getTopicsOptions = (topics) => {
        return topics.map((topic, index) => (
            <optgroup label={topic.nom} key={index}>
                {topic.sousThematique.map((subTopic, index) => (
                    <option key={index} value={`${topic.id}|${subTopic.id}`}>{subTopic.nom}</option>
                ))}
            </optgroup>
        ))
    }

    useEffect(async() => {
        setGeographicalAreas(await fetchGeographicalAreas());
        setAidTypes(await fetchAidTypes());
        setTopics(await fetchTopics());
    }, [])

    useEffect(() => {
        const fetchData = async () => {
            let response = await fetchAids(
                selectedGeographicalAreaId,
                selectedAidTypeId,
                '',
                selectedSubTopicId,
                ''
            );
            setTotalItems(response['hydra:totalItems']);
        }

        fetchData();
    }, [selectedGeographicalAreaId, selectedAidTypeId, selectedSubTopicId]);

    const onButtonClick = () => {
        let params = new URLSearchParams(window.location.search);
        params.set('region', selectedGeographicalAreaId);
        params.set('aidType', selectedAidTypeId);
        params.set('subTopic', selectedSubTopicId);
        params.set('topic', selectedTopicId);
        window.location.href = `/recherche?${params}`;
    }

    const handleSubTopicChange = e => {
        setSelectedTopicPipeSubTopicIds(e.target.value);
        const [clickedTopicId, clickedSubTopicId] = e.target.value.split('|');
        console.log(clickedTopicId, clickedSubTopicId);
        setSelectedSubTopicId(clickedSubTopicId);
        setSelectedTopicId(clickedTopicId);
    }

    return (
        <>
            <div className="fr-grid-row fr-pm-6w fr-p-2w search-forms">
                <div className="fr-col-12 fr-col-md-3">
                    <label className="fr-h3" htmlFor="selectRegion">Je suis dans la région</label>
                </div>
                <div className="fr-col-12 fr-col-md-3">
                    <select value={selectedGeographicalAreaId} onChange={(e) => setSelectedGeographicalAreaId(e.target.value)} className="fr-select" id="select" name="selectRegion">
                        <option value="">Selectionnez une région</option>
                        {getMappedOptions(geographicalAreas, 'id', 'nom')}
                    </select>
                </div>
                <div className="fr-col-12 fr-col-md-3">
                    <label className="fr-h3" htmlFor="selectAidType"> et je recherche </label>
                </div>
                <div className="fr-col-12 fr-col-md-3">
                    <select value={selectedAidTypeId} onChange={(e) => setSelectedAidTypeId(e.target.value)} className="fr-select" id="select" name="selectAidType">
                        <option value="">Selectionnez un type d'aide</option>
                        {getMappedOptions(aidTypes, 'id', 'nom')}
                    </select>
                </div>
                <div className="fr-col-12 fr-col-md-3 fr-col-offset-sm-3 fr-pt-md-2w">
                    <label className="fr-h3" htmlFor="selectTopic">dans la thématique</label>
                </div>
                <div className="fr-col-12 fr-col-md-4 fr-pt-md-2w">
                    <select value={selectedTopicPipeSubTopicIds} onChange={handleSubTopicChange} className="fr-select" id="select" name="selectTopic">
                        <option value="">Selectionnez une thématique</option>
                        {getTopicsOptions(topics)}
                    </select>
                </div>
            </div>
            <div className="fr-grid-row fr-grid-row--center fr-pt-md-6w fr-pt-4w search-cta">
                <button onClick={onButtonClick} className="fr-btn fr-btn--lg fr-fi-checkbox-circle-line fr-btn--icon-right">
                    {totalItems > 1 && 'Voir les ' + totalItems + ' aides disponibles'}
                    {totalItems === 1 && 'Voir l\'aide disponible'}
                    {totalItems === 0 && 'Voir les aides disponibles'}
                </button>
            </div>
        </>
    );
}

export default SearchEngineExtension;