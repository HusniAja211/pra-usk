<footer class="pc-footer">
      <div class="footer-wrapper container-fluid">
        <div class="row">
          <div class="col-sm-6 my-1">
            <p class="m-0">Gradient Able &#9829; crafted by Team <a href="https://codedthemes.com/" target="_blank">Codedthemes.</a>
            Distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
            </p>
          </div>
          <div class="col-sm-6 ms-auto my-1">
            <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
              <li class="list-inline-item"><a href="{{ auth()->user()->role == 'admin' ? route('admin.admin.dashboard.index') : route('user.dashboard')}}">Home</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>