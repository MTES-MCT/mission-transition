import React, { useState, useEffect } from "react";
import {fetchRegions, fetchEnvironmentalTopicCategories} from "./Api";

const AidSearchEngineExtension = () => {
    const [selectedRegion, setSelectedRegion] = useState("");
    const [selectedEnvironmentalTopicCategory, setSelectedEnvironmentalTopicCategory] = useState(null);
    const [regions, setRegions] = useState([]);
    const [environmentalCategories, setEnvironmentalCategories] = useState([]);
    const [environmentalSectors, setEnvironmentalSectors] = useState([]);
    const [showCategories, setShowCategories] = useState(true);
    const [showSectors, setShowSectors] = useState(false);
    const [categoryQueryParamName, setCategoryQueryParamName] = useState('topic');

    const fetchRegionsData = () => {
        return fetchRegions().then(result => {
            return result.map(region => ({label: region.name, value: region.id}));
        });
    };

    const fetchEnvironmentalTopicCategoriesData = () => {
        return fetchEnvironmentalTopicCategories().then(result => {
            return result.map(category => ({label: category.name, value: category.id, description: category.description, environmentalTopics: category.environmentalTopics}));
        });
    };

    useEffect(async() => {
        setRegions(await fetchRegionsData())
        const responseCategories = await fetchEnvironmentalTopicCategories();
        setEnvironmentalSectors(responseCategories.filter(category => category.name.startsWith('Secteur')))
        setEnvironmentalCategories(responseCategories.filter(category => !category.name.startsWith('Secteur')))
    }, [])

    const getRegions = () => {
        return regions.map(region => <option key={region.value} value={region.value}>{region.label}</option>)
    }

    const onCategoryClick = (event) => {
        event.preventDefault();
        let paramName = 'topic';
        if (showSectors) {
            paramName = 'sector';
            setCategoryQueryParamName('sector')
        } else {
            paramName = 'topic';
            setCategoryQueryParamName('topic')
        }
        setSelectedEnvironmentalTopicCategory(parseInt(event.target.dataset.category))
        window.location = `/recherche/resultats?${paramName}=${parseInt(event.target.dataset.category)}&region=${selectedRegion}`;
    }

    const getCategories = (categories) => {
        return categories.map(category => {
            const isSelected = selectedEnvironmentalTopicCategory === category.id;
            return (
                <div key={category.id} className={`fr-card fr-enlarge-link fr-card--no-arrow ${isSelected ? 'selected':''}`}>
                    <div className="fr-card__body">
                        <h4 className="fr-card__title">
                            <a data-category={category.id} href="#" className="fr-card__link" onClick={onCategoryClick}>{category.name}</a>
                        </h4>
                        <p className="fr-card__desc">{category.description}</p>
                    </div>
                </div>
            )
        })
    }

    const onRegionChange = (e) => {
        setSelectedRegion(e.target.value)
    }

    const onShowCategoriesChange = (e) => {
        if (!showCategories) {
            setSelectedEnvironmentalTopicCategory(null)
        }
        setShowCategories(true)
        setShowSectors(false)
    }

    const onShowSectorsChange = (e) => {
        if (!showSectors) {
            setSelectedEnvironmentalTopicCategory(null)
        }
        setShowSectors(true)
        setShowCategories(false)
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        window.location = `/recherche/resultats?${categoryQueryParamName}=${selectedEnvironmentalTopicCategory}&region=${selectedRegion}`;
    }

    const searchEnabled = selectedRegion !== "" && selectedEnvironmentalTopicCategory !== null;

    return (
        <div className="fr-container fr-pt-6w fr-pb-4w search-engine-extension">
            <div className="fr-grid-row select-region">
                <div className="col-8 col-sm-3">
                    <label className="fr-label fr-text--lead" htmlFor="select-region">
                        Votre région<span className="mandatory">*</span> :
                    </label>
                </div>
                <div className="col-8 col-sm-6 fr-ml-2w">
                    <select value={selectedRegion} onChange={onRegionChange} className="fr-select" id="select-region" name="select-region">
                        <option hidden value="">Selectionnez une localisation</option>
                        {getRegions()}
                    </select>
                </div>
            </div>
            {selectedRegion && <>
                <div className="fr-grid-row">
                    <div className="fr-form-group">
                        <fieldset className="fr-fieldset fr-fieldset--inline">
                            <legend className="fr-fieldset__legend fr-text--regular" id='radio-inline-legend'>
                                Recherchez des dispositifs avec une thématique de projet <span>ou</span> le secteur de votre enteprise<span className="mandatory">*</span>
                            </legend>
                            <div className="fr-fieldset__content">
                                <div className="fr-radio-group">
                                    <input type="radio" id="radio-inline-1" name="radio-inline" checked={showCategories} onChange={onShowCategoriesChange}/>
                                    <label className="fr-label" htmlFor="radio-inline-1">Thématique de projet écologique
                                    </label>
                                </div>
                                <div className="fr-radio-group">
                                    <input type="radio" id="radio-inline-2" name="radio-inline" checked={showSectors} onChange={onShowSectorsChange}/>
                                    <label className="fr-label" htmlFor="radio-inline-2">Secteur d'entreprise
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div className="fr-grid-row category-choices">
                    {showCategories && getCategories(environmentalCategories)}
                    {showSectors && getCategories(environmentalSectors)}
                </div>
            </>}
        </div>
    )
}

export default AidSearchEngineExtension
