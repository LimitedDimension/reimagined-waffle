import { TypedUseSelectorHook, useDispatch, useSelector } from 'react-redux'
import { RootState } from "./types/RootStateType";
import { AppDispatch } from "./store";

export const useAppSelector: TypedUseSelectorHook<RootState> = useSelector;
export const useAppDispatch = () => useDispatch<AppDispatch>();
