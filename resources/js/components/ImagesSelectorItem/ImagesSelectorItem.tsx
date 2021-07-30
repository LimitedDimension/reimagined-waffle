import * as React from "react";
import { imagesSelectorItemConfig } from "./imagesSelectorItemConfig";
import { ImagesSelectorImage } from "../../types/ImagesSelectorTypes";
import { Button } from "@material-ui/core";
import { useCallback } from "react";

type ImagesSelectorItemProps = {
    image: ImagesSelectorImage
    handleImageDelete: (id) => void,
    editMode: Boolean
}

const ImagesSelectorItem = ({ image, handleImageDelete, editMode = false }: ImagesSelectorItemProps) => {
    const handleImageDeleteClick = useCallback(() => handleImageDeleteClick(image.id), [image]);

    const editModeControls = editMode &&
        <div className="images-selector-item-controls">
            <Button variant="contained" size="small" onClick={ handleImageDeleteClick }>{ imagesSelectorItemConfig.buttonTitles.deleteButtonTitle }</Button>
        </div>

    return (
        <div className="images-selector-item">
            <img src={ image.src.toString() }
                 className="images-selector-preview"
                 alt={ imagesSelectorItemConfig.altPrefix + image.id }
            />
            { editModeControls }
        </div>
    );
};

export default ImagesSelectorItem;
