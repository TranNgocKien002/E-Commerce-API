<?php

namespace App\Http\Controllers\API;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
     // Thêm sản phẩm vào giỏ
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Đã thêm vào giỏ hàng']);
    }

    // Xem giỏ hàng của user
    public function viewCart()
    {
        $cart = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($cart);
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm trong giỏ'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['message' => 'Đã cập nhật số lượng']);
    }

    // Xóa sản phẩm khỏi giỏ
    public function removeItem($id)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ']);
    }
}
