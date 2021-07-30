import * as React from "react";
import ImagesSelectorItem from "../ImagesSelectorItem/ImagesSelectorItem";
import { ImagesSelectorImage } from "../../types/ImagesSelectorTypes";
import { imagesSelectorConfig } from "./imagesSelectorConfig";
import { Button } from "@material-ui/core";

type ImagesSelectorProps = {
    title?: String,
    images?: ImagesSelectorImage[],
    newImages?: ImagesSelectorImage[],
    deletedImages?: File[],
    handleFileChange?: (e) => void,
    handleImageDelete?: (e) => void,
    editMode?: Boolean
}

const ImagesSelector = (
    {
        title,
        images = [],
        newImages = [],
        deletedImages = [],
        handleFileChange,
        handleImageDelete,
        editMode = false
    }: ImagesSelectorProps
) => {
    const titleElement = title ? <div className="images-selector-title">{ title }</div> : null;

    const editModeControls = editMode &&
        <div className="images-selector-controls">
            <Button size="small" variant="outlined" color="primary" component="label">
                { imagesSelectorConfig.buttonTitles.addImageButtonTitle }
                <input type="file"
                       id="images-selector-input"
                       hidden={ true }
                       multiple={ imagesSelectorConfig.files.multiple }
                       accept={ imagesSelectorConfig.files.accept.join(', ') }
                       onInput={ handleFileChange }
                />
            </Button>
        </div>;

    return (
        <div className="images-selector">
            { titleElement }
            { editModeControls }
            <div className="images-selector-content">
                {
                    images.map(
                        (image, index) =>
                            <ImagesSelectorItem
                                key={ index }
                                image={ image }
                                handleImageDelete={ handleImageDelete }
                                editMode={ editMode }
                            />
                    )
                }
            </div>
        </div>
    );
};

export default ImagesSelector;

