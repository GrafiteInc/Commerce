<div class="modal fade" id="deleteModal" tabindex="-3" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">Delete Products</h4>
                <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this product?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="deleteBtn" class="btn btn-danger" href="#">Confirm Delete</a>
            </div>
        </div>
    </div>
</div>

<div id="cancelSubscription" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cancel Subcription?</h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this subscription?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="cancelBtn" class="btn btn-danger float-right">Cancel Subscription</button>
            </div>
        </div>
    </div>
</div>

<div id="deletePlanDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Plan?</h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this plan? <br>Doing so, will <b>unsubscribe</b> any active members.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="deletePlanBtn" class="btn btn-danger float-right" href="#">Delete Plan</a>
            </div>
        </div>
    </div>
</div>

<div id="deleteCouponDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Coupon?</h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this coupon?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="deleteCouponBtn" class="btn btn-danger float-right" href="#">Delete Coupon</a>
            </div>
        </div>
    </div>
</div>
