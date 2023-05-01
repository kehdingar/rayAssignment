import { useDispatch } from 'react-redux';
import { TOGGLE_ISCHECKED } from "../redux/actions";


export default function ProductItem({ id, sku, name, price, weight, size, dimensions, isChecked }) {

    const dispatch = useDispatch();

    function handleChange(e) {
        dispatch({
            type: TOGGLE_ISCHECKED,
            payload: {
                id: parseInt(e.target.value)
            }
        })
    }

    return (
        <div className="product">
            <div className="card" style={{ width: '18rem' }}>
                <div className="card-body product-list">
                    <div>
                        <input className="form-check-input delete-checkbox" type="checkbox" name={name} id="checkbox" defaultChecked={isChecked} value={id} aria-label="..." onChange={handleChange} />
                    </div>
                    <p>{sku}</p>
                    <p>{name}</p>
                    <p>{(Math.round(price * 100) / 100).toFixed(2)} $</p>
                    <p>{weight}</p>
                    <p>{size}</p>
                    <p>{dimensions}</p>
                </div>
            </div>
        </div>
    )
}