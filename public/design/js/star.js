//출력 별 (내가 쓴 리뷰)

//총 별개수
var starTotal = 5;

function star(rating, value) {// rating = 별점 값 , value = 순번 (1부터 시작)
  rating_id = "project_" + value; // 별점 class
  const starPercentage = (rating / starTotal) * 100;
  const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;// 별점 채우기
  numberRating = document.querySelector(`#${rating_id} .number`); //총 평점 텍스트 출력
  document.querySelector(`#${rating_id} .stars-inner`).style.width = starPercentageRounded; //칠해지는 별class
  numberRating.innerText = rating.toFixed(2) + "/5.00"; //총 평점 텍스트 출력
}


//출력 별 (상품) 리스트)

//총 별개수
var starTotal2 = 5;

function star2(rating, value) {// rating = 별점 값 , value = 순번 (1부터 시작)
  rating_id = "project_" + value; // 별점 class
  const starPercentage = (rating / starTotal2) * 100;
  const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;// 별점 채우기
  //numberRating = document.querySelector(`#${rating_id} .number`); //총 평점 텍스트 출력
  document.querySelector(`#${rating_id} .stars-inner`).style.width = starPercentageRounded; //칠해지는 별class
  //numberRating.innerText = rating.toFixed(2) + "/5.00"; //총 평점 텍스트 출력
}




//출력 별 (쇼핑)

//총 별개수
var shopStarTotal = 5;

function shop_star(rating, value) {// rating = 별점 값 , value = 순번 (1부터 시작)
  rating_id = "shop_project_" + value; // 별점 class
  const starPercentage = (rating / shopStarTotal) * 100;
  const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;// 별점 채우기
  numberRating = document.querySelector(`#${rating_id} .number`); //총 평점 텍스트 출력
  document.querySelector(`#${rating_id} .stars-inner`).style.width = starPercentageRounded; //칠해지는 별class
  numberRating.innerText = rating.toFixed(2) + "/5.00"; //총 평점 텍스트 출력
}


//출력 별 (메인)

//총 별개수
var shopStarTotal2 = 5;

function shop_star2(rating, value) {// rating = 별점 값 , value = 순번 (1부터 시작)
  rating_id = "shop_project2_" + value; // 별점 class
  const starPercentage = (rating / shopStarTotal2) * 100;
  const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;// 별점 채우기
  document.querySelector(`#${rating_id} .stars-inner`).style.width = starPercentageRounded; //칠해지는 별class
}

//출력 별 (메인)

//총 별개수
var shopStarTotal3 = 5;

function shop_star3(rating, value) {// rating = 별점 값 , value = 순번 (1부터 시작)
  rating_id = "shop_project3_" + value; // 별점 class
  const starPercentage = (rating / shopStarTotal3) * 100;
  const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;// 별점 채우기
  document.querySelector(`#${rating_id} .stars-inner`).style.width = starPercentageRounded; //칠해지는 별class
}








