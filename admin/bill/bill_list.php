<?php require "./header.php" ?>
<div class="main-header">
    <div class="d-flex">
        <div class="mobile-toggle" id="mobile-toggle">
            <i class="bx bx-menu"></i>
        </div>
    </div>
    <div class="dropdown d-inline-block mt-12">
        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="rounded-circle header-profile-user" src="../..<?= $ROOT_URL . $SRC_URL . $ADMIN_URL ?>/images/avatar/avt-1.png" alt="Header Avatar" />
            <span class="pulse-css"></span>
            <span class="info d-xl-inline-block color-span">
                <span class="d-block fs-20 font-w600"></span>
                <span class="d-block mt-7"></span>
            </span>
            <i class="bx bx-chevron-down"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                <span>Profile</span></a>
            <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i>
                <span>My Wallet</span></a>
            <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i>
                <span>Settings</span></a>
            <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                <span>Lock screen</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="../index.php"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                <span>Logout</span></a>
        </div>
    </div>
</div>
<div class="main">
    <div class="main-content dashboard">
        <a href="./index.php?act=view_product" class="mb-4">
            <button class="btn btn-primary">Danh sách</button>
        </a>
        <span class="<?= isset($_COOKIE['notification']) ? "noti-success" : "" ?> ">
            <?= $notification = isset($_COOKIE['notification']) ? $_COOKIE['notification'] : ""; ?>
        </span>
        <form method="GET" action="index.php" class="row g-3 mb-2">
            <input type="hidden" name="act" value="view_bill">

            <div class="col-md-3">
                <input type="text" class="form-control" name="receiver_name" placeholder="Tên người dùng" value="<?= isset($_GET['receiver_name']) ? htmlspecialchars($_GET['receiver_name']) : '' ?>">
            </div>

            <div class="col-md-2">
                <input type="date" class="form-control" name="from_date"
                    value="<?= $_GET['from_date'] ?? '' ?>"
                    max="<?= date('Y-m-d') ?>">
            </div>

            <div class="col-md-2">
                <input type="date" id="to_date" name="to_date" class="form-control"
                    value="<?= $_GET['to_date'] ?? '' ?>"
                    min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
            </div>

            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="" <?= (isset($_GET['status']) && $_GET['status'] == '') ? 'selected' : '' ?>>Tất cả</option>
                    <option value="1" <?= (isset($_GET['status']) && $_GET['status'] == '1') ? 'selected' : '' ?>>Chưa xử lý</option>
                    <option value="2" <?= (isset($_GET['status']) && $_GET['status'] == '2') ? 'selected' : '' ?>>Đã được xử lý</option>
                    <option value="3" <?= (isset($_GET['status']) && $_GET['status'] == '3') ? 'selected' : '' ?>>Đang giao hàng</option>
                    <option value="4" <?= (isset($_GET['status']) && $_GET['status'] == '4') ? 'selected' : '' ?>>Đã giao hàng</option>
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="?act=view_bill" class="btn btn-secondary">Đặt lại</a>
            </div>

        </form>


        <table id="example" class="table table-bordered table-hover" style="width:100%">
            <thead>
                <!-- <tr class="table-primary"> -->
                <tr>
                    <th>Người đặt</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $receiver_name = isset($_GET['receiver_name']) ? $_GET['receiver_name'] : '';
                $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
                $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
                $status = isset($_GET['status']) ? $_GET['status'] : '';
                ?>
                <?php $order_info = select_all_orders($receiver_name, $from_date, $to_date, $status); ?>
                <?php foreach ($order_info as $key => $value) : ?>
                    <?php $status_result = select_status_by_id($value['status_id']); ?>
                    <tr>
                        <td><?= $value['receiver_name'] ?></td>
                        <td><?= $value['receiver_email'] ?></td>
                        <td><?= $value['receiver_number_phone'] ?></td>
                        <td><?= $value['receiver_address'] ?></td>
                        <td><?= $value['created_at'] ?></td>
                        <td><span class="status_name" status="<?= $value['status_id'] ?>" style="font-weight: 500;color:<?= $value['status_id'] == 1 || $value['status_id'] == 5 ? "#e03033" : "#26820b"; ?>"><?= $status_result['status'] ?></span></td>
                        <td>
                            <?php if (($value['status_id'] == 1) || ($value['status_id'] == 2) || ($value['status_id'] == 3) || ($value['status_id'] == 4)) : ?>
                                <a href="/du_an1/admin/index.php?act=detail_bill&order_id=<?= $value['order_id'] ?>" style="display: block;text-decoration: none;">
                                    <i class="fa-solid fa-circle-info" style="color: #4287ff;font-size: 1.8rem;cursor: pointer;text-align: center;display: block;padding: 6px;"></i>
                                </a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <script>
            $('#example').DataTable();
        </script>
    </div>
</div>

<div class="overlay"></div>
<?php require "./footer.php" ?>