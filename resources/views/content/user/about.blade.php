@extends('app')

@section('content')

<div class="container">

    {{-- Page Title --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold">About Us</h2>
        <p class="text-muted">
            Learn more about our bookstore and what we offer to readers.
        </p>
    </div>

    {{-- About Section --}}
    <div class="row align-items-center mb-5">

        <div class="col-md-6">
            <img 
                src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f"
                class="img-fluid rounded shadow"
            >
        </div>

        <div class="col-md-6">

            <h4 class="fw-bold mb-3">
                Welcome to Our Book Store
            </h4>

            <p class="text-muted">
                Our bookstore is dedicated to providing high quality books 
                for readers, students, and professionals. We offer a wide 
                range of books from different categories including technology, 
                self development, education, and many more.
            </p>

            <p class="text-muted">
                Our goal is to make reading more accessible and enjoyable 
                by providing an easy online platform where users can explore, 
                add books to cart, and place orders quickly.
            </p>

        </div>

    </div>

    {{-- Vision & Mission --}}
    <div class="row text-center mb-5">

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Our Vision</h5>
                    <p class="text-muted">
                        To become a trusted online bookstore that inspires 
                        people to read, learn, and grow through knowledge.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Our Mission</h5>
                    <p class="text-muted">
                        Provide quality books with an easy and reliable 
                        ordering system so every reader can access knowledge 
                        anytime and anywhere.
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- Contact Section --}}
    <div class="card shadow-sm">
        <div class="card-body text-center">

            <h5 class="fw-bold mb-3">Contact Us</h5>

            <p class="text-muted mb-1">
                📍 Address : Jakarta, Indonesia
            </p>

            <p class="text-muted mb-1">
                📧 Email : bookstore@gmail.com
            </p>

            <p class="text-muted">
                📞 Phone : +62 812 3456 7890
            </p>

        </div>
    </div>

</div>

@endsection