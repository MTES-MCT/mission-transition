import React, {useState} from 'react'
import { fetchEnvironmentalTopicCategories, fetchAidTypes, fetchRegions } from "./Api";
import AsyncSelect from 'react-select/async'
import Select from 'react-select'


const AidSearchEngineFilters = (
    {
        aids,
        setAids,
        setFilteredAids,
        environmentalTopics,
        setEnvironmentalTopics,
        setEnvironmentalTopicCategory,
        setAidTypes,
        setRegions,
        handleSubmit,
        isSearching,
        hasTopicError,
        hasTypeError
    }) => {

    const [loading, setLoading] = useState(false);
    const [selectedEnvironmentalTopicValue, setSelectedEnvironmentalTopicValue] = useState({label: "Pas de sous-thématique", value: 0})

    //EnvironmentalTopicCategory
    const fetchEnvironmentalTopicCategoriesData = (inputValue) => {
        return fetchEnvironmentalTopicCategories().then(result => {
            setLoading(false);
            result = result.map(category => ({label: category.name, value: category.id}));
            return result.filter(topic => topic.label.toLowerCase().includes(inputValue.toLowerCase()));
        });
    };

    const handleEnvironmentalTopicCategoriesChange = (newValue) => {
        setEnvironmentalTopicCategory(newValue)
        return newValue
    }

    const getEnvironmentalTopicsOptions = () => {
        let options = [{label: "Pas de sous-thématique", value: 0}];
        aids.forEach(aid => aid.environmentalTopics.map(topic => options.push({label: topic.name, value: topic.id})))
        options = options.filter((option, index, self) =>
            index === self.findIndex((t) => (
                t.label === option.label && t.value === option.value
            ))
        )
        return options;
    }

    const handleEnvironmentalTopicsChange = (newValue) => {
        setSelectedEnvironmentalTopicValue(newValue);

        if (newValue.value === 0) {
            setFilteredAids(aids)
            return newValue;
        }
        let filteredAids = [];
        aids.forEach(aid => {
            aid.environmentalTopics.forEach(topic => {
                if (topic.id === newValue.value) {
                    filteredAids.push(aid);
                }
            })
        })
        setFilteredAids(filteredAids)

        return newValue
    }

    const EnvironmentalTopicsSelect = props => {
        return (
          <Select
            options={getEnvironmentalTopicsOptions()}
            value={selectedEnvironmentalTopicValue}
            placeholder={loading ? "Chargement" : "Choisir une sous-thématique..."}
            isDisabled={!isSearching}
            cacheOptions
            styles={{ container: (base) => ({ ...base, zIndex: 350 }) }}
            onChange={handleEnvironmentalTopicsChange}
          />
        );
    };

    const EnvironmentalTopicCategoriesSelect = props => {
        return (
            <AsyncSelect
                loadOptions={fetchEnvironmentalTopicCategoriesData}
                placeholder={loading ? "Chargement" : "Choisir une thématique..."}
                isDisabled={loading}
                defaultOptions
                cacheOptions
                styles={{ container: (base) => ({ ...base, zIndex: 500 }) }}
                onChange={handleEnvironmentalTopicCategoriesChange}
            />
        );
    };

    //AidType
    const fetchAidTypesData = (inputValue) => {
        return fetchAidTypes().then(result => {
            setLoading(false);
            result = result.map(topic => ({label: topic.name, value: topic.id}));
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
                styles={{ container: (base) => ({ ...base, zIndex: 450 }) }}
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
                defaultOptions
                isClearable
                cacheOptions
                styles={{ container: (base) => ({ ...base, zIndex: 400 }) }}
                onChange={handleRegionsChange}
            />
        );
    };

    const handlePreSubmit = (e) => {
        handleSubmit(e)
        handleEnvironmentalTopicsChange({label: "Pas de sous-thématique", value: 0})
    }
    return (
        <div className="fr-container-fluid bg-dark">
            <div className="fr-grid-row fr-mx-9w fr-py-3w">
                <div className="fr-col fr-mx-4w">
                    <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_environmentalTopic">Ma thématique</label>
                    {EnvironmentalTopicCategoriesSelect()}
                    {hasTopicError && <div className="environmental-action-error">Merci de choisir une thématique</div>}
                </div>
                <div className="fr-col fr-mx-4w">
                    <div>
                        <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_aidType">Mon besoin</label>
                        {AidTypesSelect()}
                        {hasTypeError && <div className="environmental-action-error">Merci de choisir un type de dispositif</div>}
                    </div>
                </div>
                <div className="fr-col fr-mx-4w">
                    <div>
                        <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_region">Ma localisation</label>
                        {RegionsSelect()}
                    </div>
                </div>
            </div>
            <div className="fr-grid-row fr-mx-9w">
                <div className="fr-col fr-mx-4w">
                    <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_aidType">Ma sous-thématique</label>
                    {EnvironmentalTopicsSelect()}
                </div>
                <div className="fr-col fr-mx-4w">

                </div>
                <div className="fr-col fr-mx-4w fr-mt-4w">
                    <div className="fr-search-bar" id="header-search" role="search">
                        <label className="fr-label" htmlFor="search-784-input">Recherche</label>
                        <input disabled={!isSearching} className="fr-input" placeholder="Rechercher" type="search" id="search-784-input" name="search-784-input" />
                        <button className="fr-btn" title="Rechercher">
                            Rechercher
                        </button>
                    </div>
                </div>
            </div>
            <div className="fr-grid-row fr-grid-row--center">
                <div className="fr-offset-6">
                    <button onClick={handlePreSubmit} className="fr-btn fr-btn--secondary cta-search">
                        AFFICHER LES RÉSULTATS
                    </button>
                </div>
            </div>
        </div>
    )
}

export default AidSearchEngineFilters
