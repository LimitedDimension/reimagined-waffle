import * as React from "react";
import { Link, useParams, useHistory } from "react-router-dom";
import { AdListCreateRecordData, AdListUpdateRecordData } from "../../types/AdListTypes";
import { ImagesSelectorImage } from "../../types/ImagesSelectorTypes";
import { adListItemFormConfig } from "./adListItemFormConfig";
import { adListItemByIdSelector} from "../../selectors/AdListSelectors";
import { useAppSelector } from "../../hooks";
import { useCallback, useEffect, useState } from "react";
import { useDispatch } from "react-redux";
import { usdMaskValueCheck } from "../../helpers";
import {sendAdListCreateRecord, sendAdListUpdateRecord} from "../../actions/AdListActions";
import { Button, Card, Divider, TextField} from "@material-ui/core";
import AdListItemUsdInput from "../AdListItemUsdInput/AdListItemUsdInput";
import ImagesSelector from "../ImagesSelector/ImagesSelector";
import AdListItemDateInput from "../AdListItemDateInput/AdListItemDateInput";

const AdListItemForm = () => {
    const { id } = useParams();
    const record = useAppSelector(state => adListItemByIdSelector(state, id)) || {};
    const history = useHistory();
    const dispatch = useDispatch();

    useEffect(() => {}, []);

    const [title, setTitle] = useState<String>(record.title ?? "");
    const [dateStart, setDateStart] = useState<String>(record.dateStart ?? "");
    const [dateEnd, setDateEnd] = useState<String>(record.dateEnd ?? "");
    const [usdDaily, setUsdDaily] = useState<String>(record.usdDaily ?? "");
    const [usdTotal, setUsdTotal] = useState<String>(record.usdTotal ?? "");
    const [images, setImages] = useState<ImagesSelectorImage[]>(record.images ?? []);
    const [newImages, setNewImages] = useState<ImagesSelectorImage[]>([]);
    const [deletedImages, setDeletedImages] = useState<Number[]>([]);

    useEffect(() => {}, [newImages, deletedImages]);

    /**
     * Handle the form submit callback
     */
    const handleSubmit = useCallback(e => {
        if (id) {
            const recordData: AdListUpdateRecordData = { id, title, dateStart, dateEnd, usdTotal, newImages, deletedImages};
            dispatch(sendAdListUpdateRecord(recordData, history));
        } else {
            const recordData: AdListCreateRecordData = { title, dateStart, dateEnd, usdTotal, newImages };
            dispatch(sendAdListCreateRecord(recordData, history));
        }

        e.preventDefault();
    }, [title, dateStart, dateEnd, usdDaily, usdTotal, images, newImages]);

    /**
     * Handle the USD total value change
     */
    const onChangeTotalUsd = useCallback(e => {
        const value = e.target.value;

        if (usdMaskValueCheck(value)) {
            setUsdTotal(value);
        }
    }, [usdDaily]);

    /**
     * Handle date start value change
     */
    const handleDateStartChange = useCallback(e => setDateStart(e.target.value), [setDateStart]);

    /**
     * Handle date end value change
     */
    const handleDateEndChange = useCallback(e => setDateEnd(e.target.value), [setDateEnd]);

    /**
     * Handle title value change
     */
    const handleTitleChange = useCallback(e => setTitle(e.target.value), [title]);

    /**
     * Handle file input change
     */
    const handleFileChange = useCallback(e =>
        setNewImages(
            [
                ...newImages,
                ...[...e.target.files].map(file => ({
                    id: Date.now() + file.size as Number,
                    src: URL.createObjectURL(file),
                    data: file
                }) as ImagesSelectorImage)
            ]
        )
    , [newImages]);

    /**
     * Handle image delete action
     */
    const handleImageDelete = useCallback(deletedId => {
        const isNewImage = newImages.find(image => image.id === deletedId);
        const setForDelete = deletedImages.find(id => id === deletedId);

        if (!setForDelete && !isNewImage) {
            setDeletedImages([...deletedImages, deletedId]);
            setImages(images.filter(image => image.id !== deletedId));
        }

        if (isNewImage) {
            setNewImages(newImages.filter(image => image.id !== deletedId));
        }

    }, [setDeletedImages, deletedImages, setNewImages, newImages]);

    const handleCancelClick = useCallback(() => {

    }, [newImages, setNewImages, deletedImages, setDeletedImages, images, setImages]);

    return (
        <div className="ad-list-item-form">
            <div className="ad-list-item-form-wrapper">
                <Card className="ad-list-form-card">
                    <form onSubmit={ handleSubmit }>
                        <table>
                            <tbody>
                                <tr>
                                    <td className="ad-list-item-form-title-block">
                                        <TextField value={ title }
                                                   onChange={ handleTitleChange }
                                                   label={ adListItemFormConfig.labels.titleInput }
                                                   variant="outlined"
                                                   fullWidth={ true }
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td className="ad-list-item-form-settings-block">
                                        <AdListItemDateInput
                                            dateStart={ dateStart }
                                            dateEnd={ dateEnd }
                                            handleDateStartChange={ handleDateStartChange }
                                            handleDateEndChange={ handleDateEndChange }
                                        />
                                        <AdListItemUsdInput
                                            usdDaily={ usdDaily }
                                            usdTotal={ usdTotal }
                                            handleUsdTotalChange={ onChangeTotalUsd }
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td colSpan={ 2 } className="ad-list-item-form-images">
                                         <ImagesSelector
                                            title={ adListItemFormConfig.imagesSelectorTitle }
                                            images={ [...images, ...newImages] }
                                            newImages={ newImages }
                                            handleFileChange={ handleFileChange }
                                            handleImageDelete={ handleImageDelete }
                                            editMode={ true }
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Divider />
                        <div className="ad-list-item-form-controls">
                            <Button size="small" color="primary" type="submit" variant="contained">
                                { id ? adListItemFormConfig.buttonTitles.editButtonTitle
                                    : adListItemFormConfig.buttonTitles.addButtonTitle }
                            </Button>
                            <Link to="/">
                                <Button onClick={ handleCancelClick } size="small" color="primary" variant="contained">
                                    { adListItemFormConfig.buttonTitles.cancelButtonTitle }
                                </Button>
                            </Link>
                        </div>
                    </form>
                </Card>
            </div>
        </div>
    );
}

export default AdListItemForm;
