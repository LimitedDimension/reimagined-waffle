import * as React from "react";
import { adPreviewConfig } from "./AdPreviewCofig";
import * as moment from "moment";
import ImagesSelector from "../ImagesSelector/ImagesSelector";
import { useAppSelector } from "../../hooks";
import { adListItemByIdSelector } from "../../selectors/AdListSelectors";
import { Button } from "@material-ui/core";
import { useEffect } from "react";

type AdPreviewProps = {
    id: Number,
    handleClosePreview: () => void
}

const AdPreview = ({ id, handleClosePreview }: AdPreviewProps) => {
    const record = useAppSelector(state => adListItemByIdSelector(state, id)) || null;

    useEffect(() => {
        if (!record) {
            handleClosePreview();
        }
    }, [record.id]);

    return (
        <div className="ad-preview">
            <div className="top-controls">
                <Button size="small" onClick={ handleClosePreview }>Close</Button>
            </div>
            <h3 className="ad-preview-title">{ record.title }</h3>
            <div className="ad-preview-dates">
                <div className="ad-preview-date-start">
                    <h4>{ adPreviewConfig.labels.dateStart } : { moment(record.dateStart.toString()).format(adPreviewConfig.dateFormat) } </h4>
                </div>
                <div className="ad-preview-date-end">
                    <h4>{ adPreviewConfig.labels.dateEnd } : { moment(record.dateEnd.toString()).format(adPreviewConfig.dateFormat) } </h4>
                </div>
            </div>
            <div className="ad-preview-usd">
                <div className="ad-preview-usd-daily">
                    <h4>{ adPreviewConfig.labels.usdDaily } : { record.usdDaily } </h4>
                </div>
                <div className="ad-preview-usd-total">
                    <h4>{ adPreviewConfig.labels.usdTotal } : { record.usdTotal } </h4>
                </div>
            </div>
            { record.images.length > 0 && <ImagesSelector images={ record.images } title={ adPreviewConfig.labels.images } /> }
        </div>
    );
};

export default AdPreview;
