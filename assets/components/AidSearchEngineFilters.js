import React, {useState} from 'react'
import { fetchEnvrtonmentalTopics, fetchAidTypes, fetchRegions } from "./Api";
import AsyncSelect from 'react-select/async'


const AidSearchEngineFilters = ({setEnvironmentalTopics, setAidTypes, setRegions, handleSubmit}) => {

    const [loading, setLoading] = useState(false);

    //EnvironmentalTopic
    const fetchEnvironmentalTopicsData = (inputValue) => {
        return fetchEnvrtonmentalTopics().then(result => {
            setLoading(false);
            result = result.map(topic => ({label: topic.name, value: topic.name}));
            return result.filter(topic => topic.label.toLowerCase().includes(inputValue.toLowerCase()));
        });
    };

    const handleEnvironmentalTopicsChange = (newValue) => {
        setEnvironmentalTopics(newValue)
        return newValue
    }

    const EnvironmentalTopicsSelect = props => {
        return (
          <AsyncSelect
            loadOptions={fetchEnvironmentalTopicsData}
            placeholder={loading ? "Chargement" : "Choisir une thématique..."}
            isDisabled={loading}
            isMulti
            defaultOptions
            cacheOptions
            styles={{ container: (base) => ({ ...base, zIndex: 500 }) }}
            onChange={handleEnvironmentalTopicsChange}
          />
        );
    };

    //AidType
    const fetchAidTypesData = (inputValue) => {
        return fetchAidTypes().then(result => {
            setLoading(false);
            result = result.map(topic => ({label: topic.name, value: topic.name}));
            return result.filter(topic => topic.label.toLowerCase().includes(inputValue.toLowerCase()));
        });
    };

    const handleAidTypesChange = (newValue) => {
        setAidTypes(newValue)
        return newValue
    }

    const AidTypesSelect = props => {
        return (
            <AsyncSelect
                loadOptions={fetchAidTypesData}
                placeholder={loading ? "Chargement" : "Choisir un type de dispositif..."}
                isDisabled={loading}
                isMulti
                defaultOptions
                cacheOptions
                styles={{ container: (base) => ({ ...base, zIndex: 500 }) }}
                onChange={handleAidTypesChange}
            />
        );
    };

    //Region
    const fetchRegionsData = (inputValue) => {
        return fetchRegions().then(result => {
            setLoading(false);
            result = result.map(topic => ({label: topic.name, value: topic.id}));
            return result.filter(topic => topic.label.toLowerCase().includes(inputValue.toLowerCase()));
        });
    };

    const handleRegionsChange = (newValue) => {
        setRegions(newValue)
        return newValue
    }

    const RegionsSelect = props => {
        return (
            <AsyncSelect
                loadOptions={fetchRegionsData}
                placeholder={loading ? "Chargement" : "Choisir un type de dispositif..."}
                isDisabled={loading}
                isMulti
                defaultOptions
                cacheOptions
                styles={{ container: (base) => ({ ...base, zIndex: 500 }) }}
                onChange={handleRegionsChange}
            />
        );
    };
    
    return (
        <div className="fr-container-fluid bg-dark">
                <div className="fr-grid-row">
                    <div className="fr-col fr-mx-9w fr-my-7w">
                        <label className="fr-label h3 on-dark fr-mb-3w required"
                               htmlFor="search_form_environmentalTopic">Ma thématique</label>
                        {EnvironmentalTopicsSelect()}
                        {/*<div className="environmental-action-error"></div>*/}
                    </div>
                    <div className="fr-col fr-mx-9w fr-my-7w">
                        <div><label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_aidType">Mon
                            besoin</label>
                        {AidTypesSelect()}
                        </div>
                    </div>
                    <div className="fr-col fr-mx-9w fr-my-7w">
                        <div><label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_region">Ma
                            localisation</label>
                        {RegionsSelect()}
                        </div>
                    </div>
                </div>
                <div className="fr-grid-row fr-grid-row--center">
                    <div className="fr-offset-6">
                        <button onClick={handleSubmit} className="fr-btn fr-btn--secondary cta-search">
                            AFFICHER LES RÉSULTATS
                        </button>
                    </div>
                </div>
        </div>
    )
}

export default AidSearchEngineFilters
