import { useSelector } from "react-redux"
import ProductItem from '../../components/product';

export default function Product(props) {

    const { products } = useSelector((state) => {
        return {
            products: state.products
        }
    })

    return (
        <>
            {products.map((product) => {
                return <ProductItem key={product.id} {...product} />
            })}
        </>

    )
}


