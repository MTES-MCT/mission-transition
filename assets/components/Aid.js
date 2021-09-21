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
        const applicationEndDate = new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium'}).format(new Date(aid.applicationEndDate))

        return (
            <div className="aid-dates">
                <span className="mt-icon-circled mt-icon-circled--inline">
                    <span className="mt-icon mt-icon--time"/>
                </span>
                <span className="subtitle">
                    dispostitif temporaire<br/>
                    du { applicationStartDate } au {applicationEndDate}
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

                <ul className="fr-tags-group fr-mt-4w">
                    {aid.fundingTypes.map((type, index) => <li key={index}><span className="fr-mb-3v mt-tag subtitle">{ type }</span></li>)}
                </ul>
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
