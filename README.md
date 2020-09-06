## 공적마스크 샘플 재고 정보 API

### Requirements
- PHP 7.4 이상
- Mysql(MariaDB)
- Redis

### REST API
```rest
https://api.adrinerdp.co/pharmacies?latitude&longitude&radius
```
```json
[
    {
        "name": "밝은미래약국",
        "type": 1,
        "lat": "126.8973838",
        "lng": "35.2074167",
        "addr": "---",
        "tel": "---",
        "stock_d": "09-07",
        "stock_t": "16:45",
        "stock_cnt": 143,
        "sold_cnt": 50,
        "remain_cnt": 93,
        "sold_out": false
    },
    ...
]
```


### 0. 기본 설정
- DB Migration 적용
```bash
$ php artisan migrate
```

### 1. 약국 원천 데이터 적용
- [공공데이터포털_건강보험심사평가원](https://www.data.go.kr/data/15051059/fileData.do) 를 다운로드 합니다.
- 압축 파일에서, `2. 건강보험심사평가원_약국정보서비스.xlsx`만 사용합니다.
- project root에 `pharmacies.xlsx`로 변경하여 위치시킵니다.
- 일부 필드 명칭을 변경합니다. (아래 신구대조표 참조)

| **구 필드명** | **신 필드명** |
| -------- | -------- |
| 요양기관명 | name |
| 주소 | addr |
| 전화번호 | tel |
| X좌표 | lat |
| Y좌표 | lng |

- 약국 원천 정보를 DB에 적재합니다.
```bash
php artisan api:pharmacy
```

### 2. 가상 재고 정보 생성
```bash
php artisan api:stock {type}
```
> {type} = redis(default) or sql

### Remarks
- [코드 포 코리아](https://codefor.kr)
- [광화문1번가 제안](https://www.gwanghwamoon1st.go.kr/front/propseTalk/propseTalkViewPage.do?propse_id=7a6f646cb53c4ac39ff694522ee0c04e)
- [Facebook_생활코딩](https://www.facebook.com/groups/codingeverybody/permalink/3839770152730159)
