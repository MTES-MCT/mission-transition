import React from "react";

const Aid = ({aid, last = false}) => {

    const getLowerAndUpperBound = () => {
        if (!aid.subventionRateLowerBound && !aid.subventionRateUpperBound) {
            return;
        }

        return (
            <div className="aid-type fr-mb-2w">
                        <span
                            className="mt-icon-circled mt-icon-circled--inline mt-icon-circled--blue-bg">
                            <span className="mt-icon mt-icon--euro mt-icon--color-white"/>
                        </span>
                <span className="subtitle color-navy">
                            { aid.subventionRateLowerBound !== null && (
                                'min : ' + aid.subventionRateLowerBound + '%'
                            )}
                    { aid.subventionRateLowerBound !== null && aid.subventionRateUpperBound !== null && (
                        ' / '
                    )}
                    { aid.subventionRateUpperBound !== null && (
                        'max : ' + aid.subventionRateUpperBound + '%'
                    )}
                        </span>
            </div>
        )
    }

    const getApplicationDates = () => {
        if (!aid.applicationStartDate && !aid.applicationEndDate) {
            return;
        }


        const applicationStartDate = new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium'}).format(new Date(aid.applicationStartDate))
        if (!applicationEndDate) {
            return (
                <div className="aid-dates">
                <span className="mt-icon-circled mt-icon-circled--inline">
                    <span className="mt-icon mt-icon--time"/>
                </span>
                    <span className="subtitle">
                    dispositif temporaire<br/>
                    disponible depuis le { applicationStartDate }
                </span>
                </div>
            )
        }
        const applicationEndDate = new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium'}).format(new Date(aid.applicationEndDate))

        return (
            <div className="aid-dates">
                <span className="mt-icon-circled mt-icon-circled--inline">
                    <span className="mt-icon mt-icon--time"/>
                </span>
                <span className="subtitle">
                    dispositif temporaire<br/>
                    du { applicationStartDate } au {applicationEndDate}
                </span>
            </div>
        )
    }


    const getRegions = () => {
        const getSeparator = (index) => {
            if (aid.regions.length === 1 || index === (aid.regions.length - 1)) {
                return ''
            }

            return ', '
        }

        return (
            <div className="aid-regions">
                <span className="mt-icon-circled mt-icon-circled--inline">
                    <span className="mt-icon mt-icon--finger-up"/>
                </span>
                <span className="subtitle">
                    {aid.regions.map((region, index) => <span>{ region.name + getSeparator(index) }</span>)}
                </span>
            </div>
        )
    }

    const getTypes = () => {
        const getSeparator = (index) => {
            if (aid.fundingTypes.length === 1 || index === (aid.fundingTypes.length - 1)) {
                return ''
            }

            return ', '
        }

        return (
            <div className="aid-type">
                <span className="mt-icon-circled mt-icon-circled--inline">
                    <span className="mt-icon mt-icon--euro"/>
                </span>
                <span className="subtitle">
                    {aid.fundingTypes.map((type, index) => <span>{ type + getSeparator(index) }</span>)}
                </span>
            </div>
        )
    }

    return (
        <div className="card-aid" id={last ? "last-regional-aid" : ""}>
            <div className="card-aid-main">
                <h4 className="subtitle">{aid.types.map(type => type.name).join(', ') }</h4>
                <h3 className="small">{ aid.name }</h3>
                <div className="funder">
                    <span className="mt-icon-circled mt-icon-circled--inline">
                        <span className="mt-icon mt-icon--building"/>
                    </span>
                    <span className="subtitle">{ aid.funder.name }</span>
                </div>
                {getApplicationDates()}

                {getLowerAndUpperBound()}

                {getRegions()}

                {getTypes()}
            </div>
            { aid.directAccess && (
                <a target="_blank" href={aid.fundingSourceUrl}>
                    <button className="fr-btn big card-aid-cta">VOIR LE DISPOSITIF</button>
                </a>
            )}

            { !aid.directAccess && (
                <a target="_blank" href={"/dispositif/" + aid.slug}>
                    <button className="fr-btn big card-aid-cta">VOIR LA FICHE</button>
                </a>
            )}
        </div>
    )
}

export default Aid
