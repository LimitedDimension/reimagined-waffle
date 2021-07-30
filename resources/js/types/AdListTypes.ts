import {ImagesSelectorImage} from "./ImagesSelectorTypes";

export type AdListItem = {
    id: Number,
    title: String,
    dateStart: Date,
    dateEnd: Date,
    usdDaily: Number,
    usdTotal: Number,
    images: String[],
    onShow: (id) => void,
}

export  type AdListCreateRecordData = {
    title: String,
    dateStart: String,
    dateEnd: String,
    usdTotal: String,
    newImages?: ImagesSelectorImage[]
}

export type AdListUpdateRecordData = {
    id: Number,
    title: String,
    dateStart: String,
    dateEnd: String,
    usdTotal: String,
    newImages: ImagesSelectorImage[],
    deletedImages: Number[]
}
