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
        environmentalTopicSelected,
        setEnvironmentalTopicSelected,
        setEnvironmentalTopics,
        setEnvironmentalTopicCategory,
        setAidTypes,
        setRegions,
        handleSubmit,
        isSearching,
        hasTopicError,
        searchValue,
        setSearchValue,
        hasSearchError
    }) => {

    const [loading, setLoading] = useState(false);
    const [categoryDescription, setCategoryDescription] = useState(null);
    // const [selectedEnvironmentalTopicValue, setSelectedEnvironmentalTopicValue] = useState({label: "Pas de sous-thématique", value: 0})

    const customStyles = {
        control: (provided, state) => {
            const opacity = state.isDisabled ? 0.4 : 1;

            return { ...provided, opacity };
        },

        container: (base) => ({ ...base, zIndex: 350 })
    }

    //EnvironmentalTopicCategory
    const fetchEnvironmentalTopicCategoriesData = (inputValue) => {
        return fetchEnvironmentalTopicCategories().then(result => {
            setLoading(false);
            result = result.map(category => ({label: category.name, value: category.id, description: category.description, environmentalTopics: category.environmentalTopics}));
            return result.filter(topic => topic.label.toLowerCase().includes(inputValue.toLowerCase()));
        });
    };

    const handleEnvironmentalTopicCategoriesChange = (newValue) => {

        if (newValue === null) {
            setEnvironmentalTopicCategory(newValue)
            setEnvironmentalTopicSelected(null)
            return '';
        }

        setEnvironmentalTopicCategory(newValue)
        setCategoryDescription(newValue.description);
        setEnvironmentalTopicSelected(null)
        setEnvironmentalTopics(newValue.environmentalTopics.map(topic => ({label: topic.name, value: topic.id})))
        return newValue
    }

    const handleEnvironmentalTopicsChange = (newValue) => {
        setEnvironmentalTopicSelected(newValue)
        return newValue
    }

    const EnvironmentalTopicsSelect = props => {
        return (
          <Select
            options={environmentalTopics}
            isClearable
            isDisabled={environmentalTopics.length === 0}
            placeholder={loading ? "Chargement" : "Choisir une sous-thématique..."}
            cacheOptions
            styles={customStyles}
            onChange={handleEnvironmentalTopicsChange}
            value={environmentalTopicSelected}
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
                isClearable
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
                placeholder={loading ? "Chargement" : "Choisir une région..."}
                isDisabled={loading}
                defaultOptions
                isClearable
                cacheOptions
                styles={{ container: (base) => ({ ...base, zIndex: 400 }) }}
                onChange={handleRegionsChange}
            />
        );
    };

    const onSearchChange = e => {
        setSearchValue(e.target.value)
    }

    return (
        <div className="fr-container-fluid bg-dark">
            <div className="fr-grid-row fr-px-4w fr-px-md-9w">
                <div className="fr-col-12 fr-col-md-4 fr-px-md-3w fr-mt-3w">
                    <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_environmentalTopic">Thématique</label>
                    {EnvironmentalTopicCategoriesSelect()}
                    {hasTopicError && <div className="environmental-action-error">Merci de choisir une thématique...</div>}
                    {categoryDescription && <p className="fr-pt-1w on-dark small">{categoryDescription}</p>}
                </div>
                <div className="fr-col-12 fr-col-md-4 fr-px-md-3w fr-mt-3w">
                    <div>
                        <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_aidType">Besoin</label>
                        {AidTypesSelect()}
                    </div>
                </div>
                <div className="fr-col-12 fr-col-md-4 fr-px-md-3w fr-mt-3w">
                    <div>
                        <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_region">Localisation</label>
                        {RegionsSelect()}
                    </div>
                </div>
            </div>
            <div className="fr-grid-row fr-px-4w fr-px-md-9w">
                <div className="fr-col-12 fr-col-md-4 fr-px-md-3w fr-mt-3w">
                    <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_aidType">Sous-thématique</label>
                    {EnvironmentalTopicsSelect()}
                </div>
                <div className="fr-col-12 fr-col-md-4 fr-px-md-3w fr-mt-3w">

                </div>
                <div className="fr-col-12 fr-col-md-4 fr-px-md-3w fr-mt-3w">
                    <label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search-784-input">Recherche par mots-clés</label>
                    <div className="fr-search-bar" id="header-search" role="search">
                            <input value={searchValue} onChange={onSearchChange} className="fr-input" placeholder="Titre, sujet, mot clé etc." type="search" id="search-784-input" name="search-784-input" />
                    </div>
                    {hasSearchError && <div className="environmental-action-error">...ou d'indiquer un mot-clé</div>}
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
