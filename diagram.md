erDiagram
    Artist {
        int id
        string name
        datetime startAt
        string thumbnailUrl
        bool isGroup
    }
    Release {
        int id
        string title
        datetime releasedAt
        string thumbnailUrl
        int type
        string label
    }
    Track {
        int id
        string title
        int duration
        Artist featuring
    }

    Artist 0+ -- 1+ Release : "publish"
    Release 0+ -- 1 Track : "has"
    Artist 0+ -- 0+ Track : "feature"
